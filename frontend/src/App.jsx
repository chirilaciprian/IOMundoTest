import "./index.css";
import FormPage from "./components/Pages/FormPage";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function App() {
  return (
    <>
      <ToastContainer position="top-right" autoClose={3000} hideProgressBar />
      <FormPage />
    </>
  );
}

export default App;
