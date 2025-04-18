import axios from "axios";

const API_BASE_URL = "http://localhost/IOMundoApi/api";

export const createForm = async (name, email, consent, file) => {
  const formData = new FormData();
  formData.append("name", name);
  formData.append("email", email);
  formData.append("consent", consent ? "1" : "0");
  formData.append("image", file);
  console.log("Form Data entries:");
  for (let [key, value] of formData.entries()) {
    console.log(key, value);
  }

  try {
    const response = await axios.post(`${API_BASE_URL}/submit`, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    return response.data;
  } catch (error) {
    console.error("Error creating form:", error);
    throw error;
  }
};
