import { ArrowLeft, Mail, User } from "lucide-react";
import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { Card, CardContent, CardHeader, CardTitle } from "../components/Card";
import { Button } from "../components/button";
import { Phone } from "lucide-react";
import { ApiService } from "../services/api-service";
import { ApiEndpoints } from "../constant/apiEndpoints";

interface UserDetails {
  id: number;
  nom: string;
  prenom: string;
  mail_pro: string;
  mail_perso: string;
  telephone: string;
}

export function UserDetailsPage() {
  const { id } = useParams<{ id: string }>();
  const userId = Number(id);
  const navigate = useNavigate();

  const [userDetails, setUserDetails] = useState<UserDetails | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
  const storedUser = localStorage.getItem("user");
      if (!storedUser) {
        setError("Utilisateur non connecté");
        return;
      }

      const user = JSON.parse(storedUser);
      const compteId = user.compteId || user.user?.compteId;
      const token = user.token || user.user?.token;

      if (!compteId || !token) {
        setError("Token ou compteId manquant");
      setLoading(false);
        return;
      }

  
    const fetchUserDetails = async () => {
      try {
        const url = `${ApiEndpoints.User.getdetail}/${userId}?compteId=${compteId}&token=${token}`;
        const data: UserDetails = await ApiService.getSingle(url);
        console.log(data);
        setUserDetails(data);
      } catch (err: any) {
        console.error(err);
        setError(err.response?.data?.error || "Erreur lors de la récupération de l'utilisateur");
      } finally {
        setLoading(false);
      }
    };

    fetchUserDetails();
  }, [userId]);

  if (loading) return <p>Chargement...</p>;
  if (error) return <p className="text-red-600">{error}</p>;
  if (!userDetails) return <p>Utilisateur introuvable</p>;

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="p-6">
        <Button
          variant="outline"
          onClick={() => navigate(-1)}
          className="mb-6 border-gray-300 text-gray-700 hover:bg-gray-100"
        >
          <ArrowLeft className="w-4 h-4 mr-2" />
          Retour à la liste
        </Button>

        <h1 className="text-3xl font-semibold text-gray-800 mb-2">Détails de l'utilisateur</h1>
        <p className="text-gray-600 mb-6">Informations détaillées du compte</p>

        <Card className="max-w-3xl bg-white shadow-md rounded-xl border border-gray-200">
          <CardHeader>
            <CardTitle className="text-xl text-gray-800 flex items-center">
              <User className="w-5 h-5 mr-2 text-blue-600" />
              Informations personnelles
            </CardTitle>
          </CardHeader>
          <CardContent className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <InfoField label="Nom" value={userDetails.nom} />
            <InfoField label="Prénom" value={userDetails.prenom} />
            <InfoField label="Email pro" value={userDetails.mail_pro} icon={<Mail className="w-4 h-4" />} />
            <InfoField label="Email perso" value={userDetails.mail_perso} icon={<Mail className="w-4 h-4" />} />
            <InfoField label="Téléphone" value={userDetails.telephone || ""} icon={<Phone className="w-4 h-4" />} />
          </CardContent>
        </Card>
      </div>
    </div>
  );
}

function InfoField({ label, value, icon }: { label: string; value: string; icon?: React.ReactNode }) {
  return (
    <div>
      <label className="block text-sm text-gray-600 mb-1 flex items-center gap-1">
        {icon} {label}
      </label>
      <div className="text-lg text-gray-800 bg-gray-50 p-3 rounded-lg border">
        {value}
      </div>
    </div>
  );
}
