import { Link } from "react-router-dom";
import { useAuth } from "../contexts/AuthContext";

function Navbar() {
  const { user, logout } = useAuth();

  return (
    <nav className="flex justify-between items-center px-6 py-4 bg-white border-b border-gray-200 shadow-sm">
      <Link to="/" className="text-2xl font-bold text-gray-900">
        Kognos
      </Link>
      <div className="flex items-center space-x-4">
        <Link
          to="/courses"
          className="text-gray-700 hover:text-black transition"
        >
          Cursos
        </Link>

        {!user && (
          <>
            <Link
              to="/login"
              className="text-gray-700 hover:text-black transition"
            >
              Login
            </Link>
            <Link
              to="/register"
              className="text-gray-700 hover:text-black transition"
            >
              Register
            </Link>
          </>
        )}

        {user && (
          <>
            {user.role === "user" && (
              <Link
                to="/dashboard"
                className="text-gray-700 hover:text-black transition"
              >
                Dashboard
              </Link>
            )}
            {user.role === "admin" && (
              <Link
                to="/admin/users"
                className="text-gray-700 hover:text-black transition"
              >
                Usuarios
              </Link>
            )}
            <span className="text-sm text-gray-600">Hola, {user.username}</span>
            <button
              onClick={logout}
              className="bg-black text-white px-3 py-1 rounded hover:bg-gray-800 text-sm transition"
            >
              Logout
            </button>
          </>
        )}
      </div>
    </nav>
  );
}

export default Navbar;


