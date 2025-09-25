import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "../components/button";
import { Input } from "../components/Input";
import { Card, CardContent, CardHeader, CardTitle } from "../components/Card";
import { ApiService } from "../services/api-service";
import { ApiEndpoints } from "../constant/apiEndpoints";
import { Console } from "console";

export function ForgotPasswordPage() {
  const [identifiant, setIdentifiant] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const navigate = useNavigate();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setSuccess("");

    if (!identifiant.trim()) {
      setError("L'identifiant est requis");
      return;
    }

    try {
      const response = await ApiService.create(ApiEndpoints.User.forgotPassword, { identifiant });

      if (response.idCompte) {
        console.log(response.idCompte);
        navigate("/pin", { state: { idCompte: response.idCompte } });
      } else {
        setError("Impossible de générer le code de réinitialisation");
      }
    } catch (err: any) {
      setError(err.response?.data?.error || "Erreur lors de la demande de réinitialisation");
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex items-center justify-center p-6">
      <Card className="w-full max-w-md shadow-lg border-0">
        <CardHeader className="text-center space-y-1">
          <CardTitle className="text-2xl font-bold text-gray-800">Trouvez votre compte</CardTitle>
          <p className="text-gray-600">Entrez votre identifiant</p>
        </CardHeader>
        <CardContent className="space-y-4">
          <form onSubmit={handleSubmit} className="space-y-4">
            <div className="space-y-1">
              <label className="text-gray-600 text-sm">Identifiant (mail pro ou perso)</label>
              <Input
                type="text"
                value={identifiant}
                onChange={(e) => setIdentifiant(e.target.value)}
                className="w-full border-gray-300 rounded p-2"
              />
              {error && <p className="text-red-600 text-sm">{error}</p>}
              {success && <p className="text-green-600 text-sm">{success}</p>}
            </div>
            <Button type="submit" className="w-full bg-blue-600 hover:bg-blue-700 text-white">
              Continuer
            </Button>
          </form>
          <div className="flex justify-end pt-2">
            <button
              type="button"
              className="text-sm text-blue-600 hover:underline"
              onClick={() => navigate("/login")}
            >
              Retour à la connexion
            </button>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
