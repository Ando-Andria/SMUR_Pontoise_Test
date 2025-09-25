import { useEffect, useState } from "react";
import { Card, CardContent, CardHeader, CardTitle } from "../components/Card";
import { Users, Settings, BarChart3, FileText, Shield, Database, LayoutDashboard } from "lucide-react";
import { ApiService } from "../services/api-service";
import { ApiEndpoints } from "../constant/apiEndpoints";

interface Module {
  id: number;
  nom: string;
}

interface DashboardPageProps {
  onNavigate: (page: string) => void;
}

export function DashboardPage({ onNavigate }: DashboardPageProps) {
  const [modules, setModules] = useState<Module[]>([]);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const iconMap: Record<string, any> = {
    "utilisateurs": Users,
    "statistiques": BarChart3,
    "rapports": FileText,
    "sécurité": Shield,
    "base de données": Database,
    "paramètres": Settings,
  };

  useEffect(() => {
    const fetchModules = async () => {
    const storedUser = localStorage.getItem("user");
if (storedUser) {
} else {
  setError("Token, compteId ou userId manquant dans le localStorage");
  return;
}
 const user = JSON.parse(storedUser); 
console.log(user);
 setLoading(true);
      try {
       const url = `${ApiEndpoints.User.getModules(user.user.userId)}?compteId=${user.user.compteId}&token=${user.user.token}`;
     const data = await ApiService.getList(url);
        setModules(data);
      } catch (err: any) {
        console.error(err);
        setError(err.response?.data?.error || "Erreur lors de la récupération des modules");
      } finally {
        setLoading(false);
      }
    };

    fetchModules();
  }, []);

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="p-6">
        <div className="mb-8">
          <h1 className="text-3xl text-gray-800 mb-2">Bureau</h1>
          <p className="text-gray-600">Bienvenue dans votre espace d'administration</p>
        </div>

        {error && <p className="text-red-600">{error}</p>}
        {loading ? (
          <p>Chargement...</p>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {modules.map((module) => {
              const IconComponent = iconMap[module.nom.toLowerCase()] || LayoutDashboard;
              return (
                <Card
                  key={module.id}
                  className="hover:shadow-lg transition-shadow cursor-pointer border-gray-200 hover:border-blue-300"
                  onClick={() => onNavigate(module.nom.toLowerCase())}
                >
                  <CardHeader className="flex flex-row items-center space-y-0 pb-3">
                    <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                      <IconComponent className="w-6 h-6 text-blue-600" />
                    </div>
                    <div>
                      <CardTitle className="text-lg text-gray-800">{module.nom}</CardTitle>
                    </div>
                  </CardHeader>
                  <CardContent>
                    <p className="text-gray-600">Accéder au module {module.nom}</p>
                  </CardContent>
                </Card>
              );
            })}
          </div>
        )}
      </div>
    </div>
  );
}
