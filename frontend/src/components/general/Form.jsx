import React from "react";
import { useState } from "react";
import { createForm } from "../../services/FormService";
import { toast } from "react-toastify";

function Form() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [consent, setConsent] = useState(false);
  const [file, setFile] = useState(null);

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await createForm(name, email, consent, file);
      toast.success("Form submitted successfully!");

      setTimeout(() => {
        window.location.reload();
      }, 2000);
    } catch (error) {
      const message =
        error.response?.data?.message ||
        "Error submitting form. Please try again.";
      toast.error(message);
      console.error("Error submitting form:", error);
    }
  };

  return (
    <>
      <form onSubmit={handleSubmit}>
        <div className="flex flex-col gap-2">
          <div className="flex flex-col">
            <span>Name</span>
            <input
              type="text"
              placeholder="Enter your Name"
              className="rounded-xs input bg-custom-gray border-0 input-lg w-full"
              onChange={(e) => setName(e.target.value)}
              required
            />
          </div>
          <div className="flex flex-col">
            <span>Email</span>
            <input
              type="text"
              placeholder="Enter a valid email adress"
              className="rounded-xs input bg-custom-gray border-0 input-lg w-full"
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>
          {/* <div className="flex flex-col">
            <span>Message</span>
            <textarea
              className="textarea bg-custom-gray border-0 input-lg w-full"
              placeholder="Enter your message"
            ></textarea>
          </div> */}
          <div className=" flex flex-col">
            <input
              type="file"
              className="file-input file-input-lg mt-2 bg-custom-gray"
              onChange={(e) => setFile(e.target.files[0])}
              required
            />
          </div>
        </div>
        <div className="flex flex-row gap-1 items-center mt-4">
          <input
            type="checkbox"
            defaultChecked
            className="checkbox checkbox-sm checkbox-primary rounded-sm"
            onChange={(e) => setConsent(e.target.checked)}
          />
          <div className="flex flex-row gap-1">
            <span className="gap">I accept the</span>
            <a className="link link-primary no-underline">Terms of Service</a>
          </div>
        </div>
        <button
          className="btn btn-lg btn-primary rounded-none mt-4 bg-button"
          type="submit"
        >
          Submit
        </button>
      </form>
    </>
  );
}

export default Form;
