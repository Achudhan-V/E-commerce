// This is your test publishable API key.
const stripe = Stripe("pk_test_51OTdglSEqi8lAh8n1bYQE2wLdMYOmgJcBxkgjfAI8ahkxx6r9ohV5xOgYVBDa5xr8Z097DODCd6kyatO4EK2vFnd00thPYovvm");

let elements;

initialize();
checkStatus();

document
  .querySelector("#payment-form")
  .addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {
  const { clientSecret } = await fetch("create.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
  }).then((r) => r.json());

  elements = stripe.elements({ clientSecret });

  const paymentElementOptions = {
    layout: "tabs",
  };

  const paymentElement = elements.create("payment", paymentElementOptions);
  paymentElement.mount("#payment-element");
}

async function handleSubmit(e) {
  e.preventDefault();
  setLoading(true);
  try {    
    
    const { error } = await stripe.confirmPayment({
     
      elements,
      confirmParams: {
        
        return_url: "http://127.0.0.1/Ecommerce/purchase.php",
      },
    });

    if (error) {
      console.error("Payment Failed:", error);
      showMessage(`Payment Failed: ${error.message}`);
    } else {
      
      showMessage("Payment succeeded!");
    }
  } catch (error) {
    console.error("Error during payment confirmation:", error);
    showMessage("Something went wrong. Please try again.");
  }

  setLoading(false);
}

async function checkStatus() {
  const clientSecret = new URLSearchParams(window.location.search).get(
   "payment_intent_client_secret"
  );
  

  if (!clientSecret) {
    return;
  }

  try {
    const { paymentIntent } = await stripe.retrievePaymentIntent({
      clientSecret,
    });
    switch (paymentIntent.status) {
      case "succeeded":
        showMessage("Payment succeeded!");
        break;
      case "processing":
        showMessage("Your payment is processing.");
        break;
      case "requires_payment_method":
        showMessage("Your payment requires a valid payment method. Please try again with a different card.");
        break;
      default:
        showMessage("Something went wrong.");
        break;
    }
  } catch (error) {
    console.error("Error checking payment status:", error);
    showMessage("Something went wrong. Please check your payment status later.");
  }
}

// ------- UI helpers -------

function showMessage(messageText) {
  const messageContainer = document.querySelector("#payment-message");

  messageContainer.classList.remove("hidden");
  messageContainer.textContent = messageText;

  setTimeout(function () {
    messageContainer.classList.add("hidden");
    messageContainer.textContent = "";
  }, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("#submit").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
}