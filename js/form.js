  document.addEventListener("DOMContentLoaded", statusCheck);

  let current_status;
  let delivery_date;
  let tracking;
  let delivery_label;

  // Status logic arrays
  const disabled_if_selected = ["Pending", "Cancelled"];
  const required_if_selected = ["Shipped", "In Transit"];

  function statusCheck() {

    // Initialize DOM references
    current_status = document.getElementById("status");
    delivery_date = document.getElementById("delivery_date");
    tracking = document.getElementById("tracking");
    delivery_label = document.querySelector('label[for="delivery_date"]');

    // Run once on load
    handleStatus();

    current_status.addEventListener("change", handleStatus);
  }

  function handleStatus() {
    const current = current_status.value;

    const disabled_status = disabled_if_selected.includes(current);
    const required_status = required_if_selected.includes(current);

    tracking.disabled = disabled_status;
    delivery_date.disabled = disabled_status;

    if (disabled_status) {
      tracking.value = "";
      delivery_date.value = "";
      tracking.required = false;
      delivery_date.required = false;
      delivery_label.textContent = "Expected Delivery Date";
      return; // important to stop here
    }

    tracking.disabled = false;
    delivery_date.disabled = false;
    tracking.required = false;
    delivery_date.required = false;
    delivery_label.textContent = "Expected Delivery Date";


    if (required_status) {
      tracking.required = true;
      delivery_date.required = true;
    }

 
    if (current === "Delivered") {
      tracking.required = false;
      delivery_date.required = true;
      delivery_label.textContent = "Date of Delivery";
    }
  }