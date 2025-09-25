import { Button } from "../components/button";
import { Link } from "react-router-dom";
interface HeaderProps {
  onLogout: () => void;
}

export function Header({ onLogout }: HeaderProps) {
  return (
    <header className="bg-white border-b border-gray-200 px-6 py-4">
      <div className="flex items-center justify-between">
        <div className="flex items-center space-x-3">
          <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
            <span className="text-white font-medium">S</span>
          </div>
          <span className="text-xl text-gray-800"> SMUR Pontoise</span>
        </div>
        <Link 
            to="/users" 
            className="text-gray-700 hover:text-gray-900 font-medium"
          >
            Liste Utilisateur
      </Link>
          <Button
            variant="outline"
            onClick={onLogout}
            className="border-gray-300 text-gray-700 hover:bg-gray-50"
          >
            Déconnexion
          </Button>
      </div>
    </header>
  );
}