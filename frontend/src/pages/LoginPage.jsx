import { useForm } from "react-hook-form";
import { useAuth } from "../contexts/AuthContext";
import axios from "axios";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import { useState } from "react";

function LoginPage() {
  const { register, handleSubmit } = useForm();
  const { login } = useAuth();
  const navigate = useNavigate();
  const [errors, setErrors] = useState({});

  const onSubmit = async (data) => {
    try {
      const res = await axios.post("http://localhost:8000/api/login", data);
      login(res.data.user, res.data.token);
      console.log("user devuelto:", res.data.user);
      navigate("/courses");
    } catch (err) {
      if (err.response?.status === 422) {
        setErrors(err.response.data.errors);
        toast.error("Revisa los errores del formulario.");
      } else if (err.response?.status === 401) {
        toast.error("Credenciales incorrectas");
      } else {
        toast.error("Error al iniciar sesión");
      }
    }
  };

  const renderError = (field) =>
    errors[field] && <p className="text-sm text-red-600 mt-1">{errors[field][0]}</p>;

  return (
    <div className="max-w-md mx-auto p-8 mt-16 bg-white border border-gray-300 rounded-xl shadow-lg">
      <h1 className="text-3xl font-bold mb-6 text-center text-gray-800">Iniciar sesión</h1>
      <form onSubmit={handleSubmit(onSubmit)} className="space-y-5">
        <div>
          <input
            type="email"
            placeholder="Correo electrónico"
            {...register("email", { required: true })}
            className="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-700 bg-gray-50 text-gray-800"
          />
          {renderError("email")}
        </div>

        <div>
          <input
            type="password"
            placeholder="Contraseña"
            {...register("password", { required: true })}
            className="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-700 bg-gray-50 text-gray-800"
          />
          {renderError("password")}
        </div>

        <button
          type="submit"
          className="w-full bg-black text-white py-3 rounded hover:bg-gray-800 transition"
        >
          Entrar
        </button>
      </form>
    </div>
  );
}

export default LoginPage;