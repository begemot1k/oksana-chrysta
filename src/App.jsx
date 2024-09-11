import { useState } from "react";
import oksana from '/src/assets/183670783_1568602770005593_1706032548499666435_n.jpg'
import "./App.css";
import Footer from "./components/Footer";
import Header from "./components/Header";

function App() {
  return (
    <>
      <Header />
      <section>
      <div>
          <img src={oksana} alt="Оксана" className='image' />
        </div>

        <div>
          <h3>Автор курса</h3>
          <p>
            Я, Оксана Криста, Визионер, Мастер духовных, телесных практик,
            трансформаций и быстрых изменений. Мастер Перехода и ресурсного
            состояния, Идеолог проектов будущего, которые формируют настоящее.
          </p>
        </div>
      </section>
      <div className="card"></div>
      <p className="read-the-docs"></p>
      <Footer />
    </>
  );
}

export default App;
