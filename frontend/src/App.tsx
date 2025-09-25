import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import { useState, useEffect } from "react";
import { Header } from "./pages/Header";
import { LoginPage } from "./pages/LoginPage";
import { DashboardPage } from "./pages/DashboardPage";
import { UsersPage } from "./pages/UsersPage";
import { UserDetailsPage } from "./pages/UserDetailsPage";
import { RegisterPage } from "./pages/RegisterPage";
import { ForgotPasswordPage } from "./pages/ForgotPasswordPage";
import { PinPage } from "./pages/PinPage";
import { ResetPasswordPage } from "./pages/ResetPasswordPage";

interface User {
  id: number;
  nom: string;
  prenom: string;
  email: string;
  role: string;
}

export default function App() {
  const [user, setUser] = useState<User | null>(null);

  useEffect(() => {
    const userData = localStorage.getItem("user");
    setUser(userData ? JSON.parse(userData) : null);
  }, []);

  const handleLogout = () => {
    localStorage.removeItem("user");
    setUser(null);
  };

  return (
    <Router>
      {user && <Header onLogout={handleLogout} />}

      <Routes>
        <Route path="/login" element={<LoginPage onLogin={setUser} />} />
        <Route
          path="/"
          element={user ? <Navigate to="/dashboard" /> : <LoginPage onLogin={setUser} />}
        />

        <Route path="/dashboard" element={user ? <DashboardPage /> : <Navigate to="/" />} />
        <Route path="/users" element={user ? <UsersPage /> : <Navigate to="/" />} />
        <Route path="/userDetails/:id" element={user ? <UserDetailsPage /> : <Navigate to="/" />} />

        <Route path="/register" element={<RegisterPage />} />
        <Route path="/forgotPassword" element={<ForgotPasswordPage />} />
        <Route path="/pin" element={<PinPage idcompte={123} />} />
        <Route path="/resetPassword" element={<ResetPasswordPage idcompte={123} />} />

        <Route path="*" element={<Navigate to="/" />} />
      </Routes>
    </Router>
  );
}
