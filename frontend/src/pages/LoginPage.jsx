import { useForm } from "react-hook-form";
import { useAuth } from "../contexts/AuthContext";
import axios from "axios";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";

function LoginPage() {
  const { register, handleSubmit } = useForm();
  const { login } = useAuth();
  const navigate = useNavigate();
  const onSubmit = async (data) => {
    try {
      const res = await axios.post("http://localhost:8000/api/login", data);
      login(res.data.user, res.data.token);  
      console.log("user devuelto:", res.data.user);    
      navigate("/courses"); 
    } catch (err) {
      if (err.response?.status === 401) {
        toast.error("Credenciales incorrectas");
      } else {
        toast.error("Error al iniciar sesión");
      }
    }
  };

  return (
    <div className="max-w-md mx-auto p-8 mt-16 bg-white border border-gray-300 rounded-xl shadow-lg">
      <h1 className="text-3xl font-bold mb-6 text-center text-gray-800">Iniciar sesión</h1>
      <form onSubmit={handleSubmit(onSubmit)} className="space-y-5">
        <input
          type="email"
          placeholder="Correo electrónico"
          {...register("email", { required: true })}
          className="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-700 bg-gray-50 text-gray-800"
        />
        <input
          type="password"
          placeholder="Contraseña"
          {...register("password", { required: true })}
          className="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-700 bg-gray-50 text-gray-800"
        />
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


  