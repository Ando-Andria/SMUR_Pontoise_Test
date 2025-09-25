import { useState } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import { Button } from "../components/button";
import { Input } from "../components/Input";
import { Card, CardContent, CardHeader, CardTitle } from "../components/Card";
import { ApiService } from "../services/api-service";
import { ApiEndpoints } from "../constant/apiEndpoints";

export function ResetPasswordPage() {
  const navigate = useNavigate();
  const location = useLocation();
  const idCompte = (location.state as any)?.idCompte; 
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  if (!idCompte) {
    navigate("/login");
    return null;
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setSuccess("");

    if (!password.trim() || !confirmPassword.trim()) {
      setError("Veuillez remplir tous les champs");
      return;
    }

    if (password !== confirmPassword) {
      setError("Les mots de passe ne correspondent pas");
      return;
    }

    try {
      await ApiService.create(ApiEndpoints.User.resetPassword, {
        idcompte: idCompte,
        password,
      });
      setSuccess("Mot de passe réinitialisé avec succès !");
      navigate("/login"); 
    } catch (err: any) {
      setError(err.response?.data?.error || "Erreur lors de la réinitialisation");
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex items-center justify-center p-6">
      <Card className="w-full max-w-md shadow-lg border-0">
        <CardHeader className="text-center space-y-1">
          <CardTitle className="text-2xl font-bold text-gray-800">Réinitialisation du mot de passe</CardTitle>
          <p className="text-gray-600">Entrez votre nouveau mot de passe</p>
        </CardHeader>
        <CardContent className="space-y-4">
          <form onSubmit={handleSubmit} className="space-y-4">
            <div className="space-y-1">
              <label className="text-gray-600 text-sm">Nouveau mot de passe</label>
              <Input
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full border-gray-300 rounded p-2"
              />
            </div>
            <div className="space-y-1">
              <label className="text-gray-600 text-sm">Confirmer le mot de passe</label>
              <Input
                type="password"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                className="w-full border-gray-300 rounded p-2"
              />
            </div>
            {error && <p className="text-red-600 text-sm">{error}</p>}
            {success && <p className="text-green-600 text-sm">{success}</p>}
            <Button type="submit" className="w-full bg-blue-600 hover:bg-blue-700 text-white">
              Réinitialiser
            </Button>
          </form>
          <div className="flex justify-end pt-2">
            <button
              type="button"
              className="text-sm text-blue-600 hover:underline"
              onClick={() => navigate(-1)} 
            >
              Retour
            </button>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
