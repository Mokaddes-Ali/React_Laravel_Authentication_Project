
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Register from "./components/Register";
import Login from "./components/Login";
import Dashboard from "./components/Dashboard";
import Logout from "./components/Logout";
import Home from "./components/Home";

const App = () => {
  return (
    <>
    <BrowserRouter>
    <Routes>
 
    <Route path="/" element={<Home />} />
    <Route path="/register" element={<Register />} />
    <Route path="/login" element={<Login />} />
    <Route path="/dashboard" element={<Dashboard />} />
    <Route path="/logout" element={<Logout />} />
    </Routes>

    </BrowserRouter>
   


      
    </>
  );
};

export default App;

