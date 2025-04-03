import { useForm } from "react-hook-form";
import axios from "axios";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import { useAuth } from "../contexts/AuthContext";

function RegisterPage() {
  const { register, handleSubmit } = useForm();
  const { login } = useAuth();
  const navigate = useNavigate();

  const onSubmit = async (data) => {
    try {
      const res = await axios.post("http://localhost:8000/api/register", data);
      login(res.data.token, res.data.user);
      toast.success("Registro exitoso");
      navigate("/courses");
    } catch (err) {
      if (err.response?.status === 422) {
        const errors = err.response.data.errors;
        Object.values(errors).forEach((msgs) =>
          msgs.forEach((msg) => toast.error(msg))
        );
      } else {
        toast.error("Error al registrarse");
      }
    }
  };

  return (
    <div className="max-w-md mx-auto mt-16 p-8 bg-white border border-gray-300 rounded-xl shadow-lg">
      <h1 className="text-3xl font-bold mb-6 text-center text-gray-800">Crear cuenta</h1>
      <form onSubmit={handleSubmit(onSubmit)} className="space-y-5">
        <input
          {...register("username")}
          placeholder="Nombre de usuario"
          className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
        />
        <input
          {...register("email")}
          type="email"
          placeholder="Correo electrónico"
          className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
        />
        <input
          {...register("password")}
          type="password"
          placeholder="Contraseña"
          className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
        />
        <input
          {...register("password_confirmation")}
          type="password"
          placeholder="Confirmar contraseña"
          className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
        />
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
