import { useState } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import { Button } from "../components/button";
import { Input } from "../components/Input";
import { Card, CardContent, CardHeader, CardTitle } from "../components/Card";
import { ApiService } from "../services/api-service";
import { ApiEndpoints } from "../constant/apiEndpoints";

export function PinPage() {
  const navigate = useNavigate();
  const location = useLocation();
  const idCompte = (location.state as any)?.idCompte; 

  const [pin, setPin] = useState("");
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

    if (!pin.trim()) {
      setError("Le code PIN est requis");
      return;
    }

    try {
      await ApiService.create(ApiEndpoints.User.verifyPin, { idcompte: idCompte, pin });
      setSuccess("PIN vérifié avec succès !");
      // Naviguer vers ResetPasswordPage
      navigate("/resetPassword", { state: { idCompte } });
    } catch (err: any) {
      setError(err.response?.data?.error || "Code PIN invalide");
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex items-center justify-center p-6">
      <Card className="w-full max-w-md shadow-lg border-0">
        <CardHeader className="text-center space-y-1">
          <CardTitle className="text-2xl font-bold text-gray-800">Vérification du code</CardTitle>
          <p className="text-gray-600">Entrez le code PIN reçu par email</p>
        </CardHeader>
        <CardContent className="space-y-4">
          <form onSubmit={handleSubmit} className="space-y-4">
            <div className="space-y-1">
              <label className="text-gray-600 text-sm">Code PIN</label>
              <Input
                type="text"
                value={pin}
                onChange={(e) => setPin(e.target.value)}
                className="w-full border-gray-300 rounded p-2"
              />
              {error && <p className="text-red-600 text-sm">{error}</p>}
              {success && <p className="text-green-600 text-sm">{success}</p>}
            </div>
            <Button type="submit" className="w-full bg-blue-600 hover:bg-blue-700 text-white">
              Vérifier
            </Button>
          </form>
          <div className="flex justify-end pt-2">
            <button
              type="button"
              className="text-sm text-blue-600 hover:underline"
              onClick={() => navigate("/forgotPassword")}
            >
              Retour
            </button>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
