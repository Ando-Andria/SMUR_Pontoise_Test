import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "../components/button";
import { Input } from "../components/Input";
import { Card, CardContent, CardHeader, CardTitle } from "../components/Card";
import { ApiService } from "../services/api-service";
import { ApiEndpoints } from "../constant/apiEndpoints";
import { User, Shield } from "lucide-react";

interface LoginPageProps {
  onLogin?: (user: any) => void;
}

export function LoginPage({ onLogin }: LoginPageProps) {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [errors, setErrors] = useState<{ [key: string]: string }>({});
  const [serverError, setServerError] = useState("");

  const navigate = useNavigate();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    // Validation simple
    const newErrors: { [key: string]: string } = {};
    if (!username.trim()) newErrors.username = "L'identifiant est requis";
    if (!password) newErrors.password = "Le mot de passe est requis";
    setErrors(newErrors);
    if (Object.keys(newErrors).length > 0) return;

    try {
      const data = { identifiant: username, mot_de_passe: password };
      const response = await ApiService.create(ApiEndpoints.login, data);

      // Sauvegarder utilisateur
      localStorage.setItem("user", JSON.stringify(response.user));

      // ✅ Mettre à jour App.tsx via onLogin
      if (onLogin) onLogin(response.user);

      // Rediriger vers dashboard
      navigate("/dashboard");
    } catch (err: any) {
      setServerError(err.response?.data?.error || "Erreur lors de la connexion");
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex items-center justify-center p-6">
      <Card className="w-full max-w-md shadow-lg border-0">
        <CardHeader className="text-center space-y-1">
          <CardTitle className="text-2xl font-bold text-gray-800">
            SMUR Pontoise
          </CardTitle>
        </CardHeader>
        <CardContent className="space-y-4">
          <form onSubmit={handleSubmit} className="space-y-4">
            <InputField
              label="Identifiant"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              icon={<User className="w-4 h-4" />}
              error={errors.username}
            />
            <InputField
              label="Mot de passe"
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              icon={<Shield className="w-4 h-4" />}
              error={errors.password}
            />

            {serverError && (
              <p className="text-red-600 text-sm">{serverError}</p>
            )}

            <Button
              type="submit"
              className="w-full bg-blue-600 hover:bg-blue-700 text-white"
            >
              Se connecter
            </Button>
          </form>

          <div className="flex justify-between pt-2">
            <button
              type="button"
              className="text-sm text-blue-600 hover:underline"
              onClick={() => navigate("/register")}
            >
              S'inscrire
            </button>

            <button
              type="button"
              className="text-sm text-blue-600 hover:underline"
              onClick={() => navigate("/forgotPassword")}
            >
              Mot de passe oublié ?
            </button>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}

// 🔹 Composant champ réutilisable
function InputField({
  label,
  value,
  onChange,
  type = "text",
  icon,
  error,
}: {
  label: string;
  value: string;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
  type?: string;
  icon?: React.ReactNode;
  error?: string;
}) {
  return (
    <div className="space-y-1">
      <label className="flex items-center gap-1 text-gray-600 text-sm">
        {icon} {label}
      </label>
      <Input
        type={type}
        value={value}
        onChange={onChange}
        className="w-full border-gray-300 rounded p-2"
      />
      {error && <p className="text-red-600 text-sm">{error}</p>}
    </div>
  );
}
