import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import 'react-toastify/dist/ReactToastify.css';
import { ToastContainer } from 'react-toastify';
import { AuthProvider } from "./contexts/AuthContext"; 
import './index.css'
import App from './App.jsx'
import React from 'react';

createRoot(document.getElementById('root')).render(
<React.StrictMode>
  <AuthProvider>
    <App />
  </AuthProvider>
</React.StrictMode>
)
