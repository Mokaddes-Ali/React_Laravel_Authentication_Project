import React, { useEffect, useState } from "react";
import { fetchDashboard } from "../services/api";
import Logout from "./Logout";

const Dashboard = () => {
  const [data, setData] = useState(null);

  useEffect(() => {
    const getData = async () => {
      const response = await fetchDashboard();
      setData(response);
    };

    getData();
  }, []);

  return (
    <div>
      <h1>Dashboard</h1>
      {data ? <pre>{JSON.stringify(data, null, 2)}</pre> : <p>Loading...</p>}
      <Logout />
    </div>
  );
};

export default Dashboard;
