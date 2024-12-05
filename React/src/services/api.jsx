import axios from "axios";

// Create an Axios instance with a base URL
const api = axios.create({
  baseURL: "http://localhost:8000/api", // Replace with your Laravel API URL
});

// Register user
export const registerUser = async (formData) => {
  try {
    const response = await api.post("/register", formData);
    return response.data;
  } catch (error) {
    console.error("Registration error:", error.response?.data || error.message);
    throw error.response?.data || error;
  }
};

// Login user
export const loginUser = async (formData) => {
  try {
    const response = await api.post("/login", formData);
    return response.data;
  } catch (error) {
    console.error("Login error:", error.response?.data || error.message);
    throw error.response?.data || error;
  }
};

// Logout user
export const logoutUser = async () => {
  try {
    const response = await api.post("/logout", null, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if required
      },
    });
    return response.data;
  } catch (error) {
    console.error("Logout error:", error.response?.data || error.message);
    throw error.response?.data || error;
  }
};

// Fetch dashboard data
export const fetchDashboard = async () => {
  try {
    const response = await api.get("/dashboard", {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if required
      },
    });
    return response.data;
  } catch (error) {
    console.error("Dashboard fetch error:", error.response?.data || error.message);
    throw error.response?.data || error;
  }
};

// Export the Axios instance for further customization if needed
export default api;
