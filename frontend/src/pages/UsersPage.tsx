import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Input } from "../components/Input";
import { Button } from "../components/button";
import { Card, CardContent, CardHeader, CardTitle } from "../components/Card";
import { Search } from "lucide-react";
import { ApiService } from "../services/api-service";
import { ApiEndpoints } from "../constant/apiEndpoints";

interface User {
  id: number;
  nom: string;
  prenom: string;
  email?: string;
  role?: string;
}

export function UsersPage() {
  const navigate = useNavigate();
  const [users, setUsers] = useState<User[]>([]);
  const [searchTerm, setSearchTerm] = useState("");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  useEffect(() => {
    const fetchUsers = async () => {
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
        return;
      }

      setLoading(true);
      try {
        const url = `${ApiEndpoints.User.getAll}?compteId=${compteId}&token=${token}`;
        const data = await ApiService.getList(url);
        setUsers(data);
      } catch (err: any) {
        console.error(err);
        setError(err.response?.data?.error || "Erreur lors de la récupération des utilisateurs");
      } finally {
        setLoading(false);
      }
    };

    fetchUsers();
  }, []);

  const filteredUsers = users.filter(
    (user) =>
      user.nom.toLowerCase().includes(searchTerm.toLowerCase()) ||
      user.prenom.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const handleViewDetails = (user: User) => {
    localStorage.setItem("selectedUser", JSON.stringify(user));
    navigate(`/userDetails/${user.id}`);
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="p-6">
        <h1 className="text-3xl text-gray-800 mb-2">Gestion des utilisateurs</h1>
        <p className="text-gray-600 mb-4">Gérez les comptes utilisateurs</p>

        {error && <p className="text-red-600">{error}</p>}
        {loading ? (
          <p>Chargement...</p>
        ) : (
          <Card className="border-gray-200">
            <CardHeader>
              <CardTitle className="text-xl text-gray-800">Liste des utilisateurs</CardTitle>
              <div className="relative mt-2">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
                <Input
                  placeholder="Rechercher un utilisateur"
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="pl-10 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                />
              </div>
            </CardHeader>
            <CardContent>
              <table className="w-full">
                <thead>
                  <tr className="border-b border-gray-200">
                    <th className="text-left py-4 px-4 text-gray-700">Nom</th>
                    <th className="text-left py-4 px-4 text-gray-700">Prénom</th>
                    <th className="text-right py-4 px-4 text-gray-700">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {filteredUsers.map((user) => (
                    <tr key={user.id} className="border-b border-gray-100 hover:bg-gray-50">
                      <td className="py-4 px-4 text-gray-800">{user.nom}</td>
                      <td className="py-4 px-4 text-gray-800">{user.prenom}</td>
                      <td className="py-4 px-4 text-right">
                        <Button variant="outline" size="sm" onClick={() => handleViewDetails(user)}>
                          Voir détails
                        </Button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
              {filteredUsers.length === 0 && (
                <div className="text-center py-8 text-gray-500">Aucun utilisateur trouvé</div>
              )}
            </CardContent>
          </Card>
        )}
      </div>
    </div>
  );
}
