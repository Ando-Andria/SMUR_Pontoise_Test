import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "../components/button";
import { Input } from "../components/Input";
import { Card, CardContent, CardHeader, CardTitle } from "../components/Card";
import { Label } from "../components/Label";
import { ApiService } from "../services/api-service";
import { ApiEndpoints } from "../constant/apiEndpoints";

export function RegisterPage() {
  const navigate = useNavigate();

  const [nom, setNom] = useState("");
  const [prenom, setPrenom] = useState("");
  const [mailPro, setMailPro] = useState("");
  const [mailPerso, setMailPerso] = useState("");
  const [identifiantType, setIdentifiantType] = useState<"pro" | "perso">("pro");
  const [motDePasse, setMotDePasse] = useState("");
  const [telephone, setTelephone] = useState("");
  const [errors, setErrors] = useState<{ [key: string]: string }>({});
  const [serverError, setServerError] = useState("");

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const newErrors: { [key: string]: string } = {};

    if (!nom.trim()) newErrors.nom = "Le nom est requis";
    if (!prenom.trim()) newErrors.prenom = "Le prénom est requis";
    if (!mailPro.trim()) newErrors.mailPro = "Le mail pro est requis";
    if (!mailPerso.trim()) newErrors.mailPerso = "Le mail perso est requis";
    if (!motDePasse) newErrors.motDePasse = "Le mot de passe est requis";
    if (!telephone.trim()) newErrors.telephone = "Le téléphone est requis";

    setErrors(newErrors);
    if (Object.keys(newErrors).length > 0) return;

    try {
      const identifiant = identifiantType === "pro" ? mailPro : mailPerso;

      const data = {
        nom,
        prenom,
        mail_pro: mailPro,
        mail_perso: mailPerso,
        identifiant,
        mot_de_passe: motDePasse,
        telephone,
      };

      console.log(data);
      await ApiService.create(ApiEndpoints.User.add, data);

      navigate("/login");
    } catch (err: any) {
      setServerError(err.response?.data?.error || "Erreur lors de l'inscription");
    }
  };

  const inputClass =
    "w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500";

  return (
    <div className="min-h-screen bg-gray-50 flex items-center justify-center p-6">
      <Card className="w-full max-w-md shadow-lg border-0">
        <CardHeader className="space-y-1 text-center">
          <CardTitle className="text-2xl text-gray-800 font-bold">Inscription</CardTitle>
          <p className="text-gray-600">Créez votre compte</p>
        </CardHeader>
        <CardContent className="space-y-4">
          <form onSubmit={handleSubmit} className="space-y-4">
            <div className="space-y-1">
              <Label htmlFor="nom">Nom</Label>
              <Input
                id="nom"
                type="text"
                value={nom}
                onChange={(e) => setNom(e.target.value)}
                className={inputClass}
              />
              {errors.nom && <p className="text-red-600 text-sm">{errors.nom}</p>}
            </div>

            <div className="space-y-1">
              <Label htmlFor="prenom">Prénom</Label>
              <Input
                id="prenom"
                type="text"
                value={prenom}
                onChange={(e) => setPrenom(e.target.value)}
                className={inputClass}
              />
              {errors.prenom && <p className="text-red-600 text-sm">{errors.prenom}</p>}
            </div>

            <div className="space-y-1">
              <Label htmlFor="mailPro">Mail pro</Label>
              <Input
                id="mailPro"
                type="email"
                value={mailPro}
                onChange={(e) => setMailPro(e.target.value)}
                className={inputClass}
              />
              {errors.mailPro && <p className="text-red-600 text-sm">{errors.mailPro}</p>}
            </div>

            <div className="space-y-1">
              <Label htmlFor="mailPerso">Mail perso</Label>
              <Input
                id="mailPerso"
                type="email"
                value={mailPerso}
                onChange={(e) => setMailPerso(e.target.value)}
                className={inputClass}
              />
              {errors.mailPerso && <p className="text-red-600 text-sm">{errors.mailPerso}</p>}
            </div>

            <div className="space-y-1">
              <Label htmlFor="telephone">Téléphone</Label>
              <Input
                id="telephone"
                type="text"
                value={telephone}
                onChange={(e) => setTelephone(e.target.value)}
                className={inputClass}
              />
              {errors.telephone && <p className="text-red-600 text-sm">{errors.telephone}</p>}
            </div>

            <div className="space-y-1">
              <Label>Choisir l'identifiant de connexion</Label>
              <div className="flex gap-4">
                <label className="flex items-center gap-2">
                  <input
                    type="radio"
                    name="identifiant"
                    value="pro"
                    checked={identifiantType === "pro"}
                    onChange={() => setIdentifiantType("pro")}
                  />
                  Mail pro
                </label>
                <label className="flex items-center gap-2">
                  <input
                    type="radio"
                    name="identifiant"
                    value="perso"
                    checked={identifiantType === "perso"}
                    onChange={() => setIdentifiantType("perso")}
                  />
                  Mail perso
                </label>
              </div>
            </div>

            <div className="space-y-1">
              <Label htmlFor="motDePasse">Mot de passe</Label>
              <Input
                id="motDePasse"
                type="password"
                value={motDePasse}
                onChange={(e) => setMotDePasse(e.target.value)}
                className={inputClass}
              />
              {errors.motDePasse && <p className="text-red-600 text-sm">{errors.motDePasse}</p>}
            </div>

            {serverError && <p className="text-red-600 text-sm">{serverError}</p>}

            <Button type="submit" className="w-full bg-blue-600 hover:bg-blue-700 text-white">
              S'inscrire
            </Button>
          </form>
        </CardContent>
      </Card>
    </div>
  );
}
