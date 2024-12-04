import React, { useState } from "react";
import { registerUser } from "../services/api";

const Register = () => {
  const [formData, setFormData] = useState({
    first_name: "",
    last_name: "",
    email: "",
    password: "",
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    const response = await registerUser(formData);
    console.log(response);
  };

  return (
    <form onSubmit={handleSubmit}>
      <input type="text" placeholder="First Name" onChange={(e) => setFormData({ ...formData, first_name: e.target.value })} />
      <input type="text" placeholder="Last Name" onChange={(e) => setFormData({ ...formData, last_name: e.target.value })} />
      <input type="email" placeholder="Email" onChange={(e) => setFormData({ ...formData, email: e.target.value })} />
      <input type="password" placeholder="Password" onChange={(e) => setFormData({ ...formData, password: e.target.value })} />
      <button type="submit">Register</button>
    </form>
  );
};

export default Register;
