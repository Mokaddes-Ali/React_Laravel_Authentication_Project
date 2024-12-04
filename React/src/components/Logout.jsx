import React from "react";
import { logoutUser } from "../services/api";

const Logout = () => {
  const handleLogout = async () => {
    const response = await logoutUser();
    console.log(response);
  };

  return <button onClick={handleLogout}>Logout</button>;
};

export default Logout;
