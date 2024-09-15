import { useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTelegram } from "@fortawesome/free-brands-svg-icons";
import { faWhatsapp } from "@fortawesome/free-brands-svg-icons";

import img1program from "/src/assets/58430931.png";
import img1message from "/src/assets/58431193.png";
import img1gap1 from "/src/assets/gap1.png";
import img1gap2 from "/src/assets/gap2.png";

import img5prices from "/src/assets/58545744.png";
import img5price1 from "/src/assets/58432134.png";
import img5price2 from "/src/assets/58432142.png";
import img5price3 from "/src/assets/58432178.png";

import img6clients from "/src/assets/58578832.png";
import img7author from "/src/assets/58657402.png";
import img8gave from "/src/assets/58657408.png";
import img9cert from "/src/assets/60515611.jpg";
import imgAcontacts from "/src/assets/58432201.png";

function App() {
  const clickHandler = (e) => {
    const url = e.target.dataset.url;
    console.log(url);
    window.open(url);
  };
  const [pricesVisible, setPricesVisible] = useState(false);

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
        <img alt="" src={img1gap1} className="imgs" />
        <b className="txt">
          Экстатичное Тело — это Красота Сердца, Души и Тела. Это про глубинную
          связь с собой, про звучение своей истиной из Сердца, про единение со
          своей Сутью... Про Сияние и изЛучение Сути в Мир... Дарение Себя
          Миру... ИзЛучение своей сексуальной энергии, а значит позволение Жизни
          течь своей бурной рекой через себя... Это слиться в едином Танце с
          Жизнью, в её ритмах и Потоках, в вибрациях и свечении... Выявить все
          грани Алмаза Души, отшлифовать и Сверкать, переливаясь в Лучах
          Солнца... Это про Экстаз от Жизни. Готовы? Нырнуть в свою Глубину? А я
          рядом, я проВеду... Программа Экстатичное Тело
        </b>
        <img alt="" src={img1gap2} className="imgs" />
        <img
          alt=""
          src={img5prices}
          className="imgs"
          onClick={() => setPricesVisible(!pricesVisible)}
        />
        {pricesVisible && (
          <>
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
          </>
        )}
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
