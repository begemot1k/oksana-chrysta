import whatsapp from "../assets/WhatsAppButtonWhiteMedium.png";
export const Footer = () => {
  return (
    <footer>
      <div>
        <h3>Контакты</h3>
        <div className="contacts__list">
          <div className="contacts__item">
            <a
              aria-label="Chat on Telegram"
              target="_blank"
              href="tg://resolve?domain=oksimillion&text=Здравствуйте!"
            >
              <img alt="Chat on WhatsApp" src={whatsapp} width={200} />
            </a>
          </div>
          <div className="contacts__item">
            <a
              aria-label="Chat on WhatsApp"
              target="_blank"
              href="whatsapp://send?phone=79169232878&text=Здравствуйте!"
            >
              <img alt="Chat on WhatsApp" src={whatsapp} width={200} />
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
};
export default Footer;
