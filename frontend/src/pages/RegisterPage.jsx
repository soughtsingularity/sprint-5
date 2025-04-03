import { useForm } from "react-hook-form";
import axios from "axios";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import { useAuth } from "../contexts/AuthContext";
import { useState } from "react";

function RegisterPage() {
  const { register, handleSubmit } = useForm();
  const { login } = useAuth();
  const navigate = useNavigate();
  const [errors, setErrors] = useState({});

  const onSubmit = async (data) => {
    try {
      const res = await axios.post("http://localhost:8000/api/register", data);
      login(res.data.user, res.data.token);
      navigate("/courses");
    } catch (err) {
      if (err.response?.status === 422) {
        setErrors(err.response.data.errors);
        toast.error("Revisa los errores del formulario.");
      } else {
        toast.error("Error al registrarse");
      }
    }
  };

  const renderError = (field) =>
    errors[field] && <p className="text-sm text-red-600 mt-1">{errors[field][0]}</p>;

  return (
    <div className="max-w-md mx-auto mt-16 p-8 bg-white border border-gray-300 rounded-xl shadow-lg">
      <h1 className="text-3xl font-bold mb-6 text-center text-gray-800">Crear cuenta</h1>
      <form onSubmit={handleSubmit(onSubmit)} className="space-y-5">
        <div>
          <input
            {...register("username")}
            placeholder="Nombre de usuario"
            className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
          />
          {renderError("username")}
        </div>

        <div>
          <input
            {...register("email")}
            type="email"
            placeholder="Correo electrónico"
            className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
          />
          {renderError("email")}
        </div>

        <div>
          <input
            {...register("password")}
            type="password"
            placeholder="Contraseña"
            className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
          />
          {renderError("password")}
        </div>

        <div>
          <input
            {...register("password_confirmation")}
            type="password"
            placeholder="Confirmar contraseña"
            className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
          />
          {renderError("password_confirmation")}
        </div>

        <button
          type="submit"
          className="w-full bg-black text-white py-3 rounded hover:bg-gray-800 transition"
        >
          Registrarse
        </button>
      </form>
    </div>
  );
}

export default RegisterPage;
