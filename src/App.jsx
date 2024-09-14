import { useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTelegram } from "@fortawesome/free-brands-svg-icons";
import { faWhatsapp } from "@fortawesome/free-brands-svg-icons";

import img1program from "/src/assets/58430931.png";
import img1message from "/src/assets/58431193.png";
import img1gap from "/src/assets/58431204.png";

import img5prices from "/src/assets/58545744.png";
import img5price1 from "/src/assets/58432134.png";
import img5price2 from "/src/assets/58432142.png";
import img5price3 from "/src/assets/58432178.png";

import img6clients from "/src/assets/58578832.png";
import img7author from "/src/assets/58657402.png";
import img8gave from "/src/assets/58657408.png";
import img9cert from "/src/assets/60515611.jpg";
import imgAcontacts from "/src/assets/58432201.png";

const clickHandler = (e) => {
  const url = e.target.dataset.url;
  console.log(url);
  window.open(url);
};

function App() {
  return (
    <>
      <main className="sheet">
        <img alt="Премиальная программа" src={img1program} className="imgs" />
        <img
          alt=""
          src={img1message}
          className="imgs"
          data-url="https://t.me/oksimillion?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5!"
          onClick={clickHandler}
        />
        <img alt="" src={img1gap} className="imgs" />
        <img alt="" src={img5prices} className="imgs" />
        <img
          alt=""
          src={img5price1}
          className="imgs"
          data-url="https://t.me/oksimillion?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5!"
          onClick={clickHandler}
        />
        <img
          alt=""
          src={img5price2}
          className="imgs"
          data-url="https://t.me/oksimillion?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5!"
          onClick={clickHandler}
        />
        <img
          alt=""
          src={img5price3}
          className="imgs"
          data-url="https://t.me/oksimillion?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5!"
          onClick={clickHandler}
        />
        <img alt="" src={img6clients} className="imgs" />
        <img alt="" src={img7author} className="imgs" />
        <img alt="" src={img8gave} className="imgs" />
        <b className="txt">
          Курс можно купить в подарок друзьям, коллегам, всем тем, кому Вы
          желаете счастья...
        </b>
        <img alt="" src={img9cert} className="imgs" />
        <img alt="" src={imgAcontacts} className="imgs" />
        <div className="contacts__list center">
          <div
            className="contacts__item  btn"
            data-url="https://t.me/oksimillion?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5!"
            onClick={clickHandler}
          >
            <FontAwesomeIcon icon={faTelegram} size="lg" /> Telegram
          </div>
          <div
            className="contacts__item btn"
            data-url="https://wa.me/79169232878?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5!"
            onClick={clickHandler}
          >
            <FontAwesomeIcon icon={faWhatsapp} size="lg" /> WhatsApp
          </div>
        </div>
      </main>
      <div className="card"></div>
      <p className="read-the-docs"></p>
    </>
  );
}

export default App;
