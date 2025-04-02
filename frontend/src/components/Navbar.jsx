import { Link } from "react-router-dom";
import { useContext } from "react";
import { AuthContext } from "../contexts/AuthContext";

function Navbar() {
  const { user, logout } = useContext(AuthContext);

  return (
    <nav className="flex justify-between items-center px-6 py-3 bg-gray-100 shadow">
      <Link to="/" className="text-xl font-bold text-blue-700">
        Kognos
      </Link>
      <div className="flex items-center space-x-4">
        <Link to="/courses" className="text-gray-700 hover:text-blue-700">
          Courses
        </Link>
        {!user && (
          <>
            <Link to="/login" className="text-gray-700 hover:text-blue-700">
              Login
            </Link>
            <Link to="/register" className="text-gray-700 hover:text-blue-700">
              Register
            </Link>
          </>
        )}
        {user && (
          <>
            <span className="text-sm text-gray-600">Hello, {user.name}</span>
            <button
              onClick={logout}
              className="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm"
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
