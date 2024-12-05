import React, { useState } from "react";
import axios from "axios";
import "bootstrap/dist/css/bootstrap.min.css";

const Register = () => {
  const [first_name, setFirstName] = useState("");
  const [last_name, setLastName] = useState(""); // State for last name
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError("");
    setSuccess("");

    try {
      const response = await axios.post("http://127.0.0.1:8000/api/register", {
        first_name,
        last_name, // Include last name in the request
        email,
        password,
      });

      console.log("Response:", response.data);
      setSuccess("Registration successful! Please log in.");
    } catch (err) {
      setLoading(false);
      if (err.response) {
        console.error("Error response:", err.response);
        if (err.response.data.errors) {
          setError(err.response.data.errors.email || "Registration failed. Please try again.");
        } else {
          setError(err.response.data.message || "Registration failed");
        }
      } else {
        setError("Something went wrong.");
      }
    }
  };

  return (
    <div className="container mt-5">
      <div className="row justify-content-center">
        <div className="col-sm-12 col-md-10 col-lg-12">
          <div className="card shadow">
            <div className="card-body">
              <h2 className="text-center mb-4">Register</h2>
              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label htmlFor="first_name" className="form-label">
                    First Name
                  </label>
                  <input
                    type="text"
                    className="form-control"
                    id="first_name"
                    value={first_name}
                    onChange={(e) => setFirstName(e.target.value)}
                    required
                  />
                </div>
                <div className="mb-3">
                  <label htmlFor="last_name" className="form-label">
                    Last Name
                  </label>
                  <input
                    type="text"
                    className="form-control"
                    id="last_name"
                    value={last_name}
                    onChange={(e) => setLastName(e.target.value)}
                    required
                  />
                </div>
                <div className="mb-3">
                  <label htmlFor="email" className="form-label">
                    Email
                  </label>
                  <input
                    type="email"
                    className="form-control"
                    id="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                  />
                </div>
                <div className="mb-3">
                  <label htmlFor="password" className="form-label">
                    Password
                  </label>
                  <input
                    type="password"
                    className="form-control"
                    id="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                  />
                </div>
                <button type="submit" className="btn btn-primary w-100" disabled={loading}>
                  {loading ? "Registering..." : "Register"}
                </button>
              </form>

              {error && <div className="alert alert-danger mt-3">{error}</div>}
              {success && <div className="alert alert-success mt-3">{success}</div>}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Register;
