import React from "react";
import Register from "./components/Register";
import Login from "./components/Login";
import Dashboard from "./components/Dashboard";
import Logout from "./components/Logout";

const App = () => {
  return (
    <div>
      <Register />
      <Login />
      <Dashboard />
      <Logout />
    </div>
  );
};

export default App;

