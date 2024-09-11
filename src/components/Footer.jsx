import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTelegram } from "@fortawesome/free-brands-svg-icons";
import { faWhatsapp } from "@fortawesome/free-brands-svg-icons";
export const Footer = () => {
  return (
    <footer>
      <div>
        <h3>Контакты</h3>
        <div className="contacts__list center">
          <a
            aria-label="Chat on Telegram"
            target="_blank"
            href="tg://resolve?domain=oksimillion&text=Здравствуйте!"
            className=""
          >
            <div className="contacts__item  btn">
              <FontAwesomeIcon icon={faTelegram} size="lg" /> Telegram
            </div>
          </a>
          <a
            aria-label="Chat on WhatsApp"
            target="_blank"
            href="whatsapp://send?phone=79169232878&text=Здравствуйте!"
          >
            <div className="contacts__item btn">
              <FontAwesomeIcon icon={faWhatsapp} size="lg" /> WhatsApp
            </div>
          </a>
        </div>
      </div>
    </footer>
  );
};
export default Footer;
