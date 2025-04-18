import React from "react";
import Form from "../general/Form"
import avatarImage from "../../assets/pexels-photo-10435040.jpeg";

function FormPage() {
  return <>    
    <div className="flex lg:flex-row flex-col items-center  h-screen w-screen lg:gap-10 overflow-x-hidden lg:mt-0 mt-10">
        <div className="avatar justify-start lg:justify-end w-5/6 lg:w-1/2 lg:relative lg:-top-[150px]">
          <div className="rounded-full sm:h-100 max-h-100 ">
            <img src={avatarImage} />
          </div>
        </div>
        <div className="w-5/6 lg:w-1/3 ">
          <Form />
        </div>
      </div>
  </>
}

export default FormPage;
