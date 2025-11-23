<?php include '../includes/header-loader.php'; ?>
<div class="container slp-theme-light rounded mt-5 mb-5">
  <h1 class="text-center p-3">Shipping Form</h1>
  <form id="shippingForm" method="POST" action="process_shipping_request.php">
    <fieldset>
      <div class="row m-3 p-3 border border-dark rounded shadow">
        <legend class="text-center">Dates</legend>

        <div class="col">
          <label for="today_date" class="form-label">Today's Date</label>
          <input type="date" id="today_date" name="today_date" class="form-control" required />
        </div>

        <div class="col">
          <label for="requested_date" class="form-label">Requested Ship Date</label>
          <input
            type="date"
            id="requested_date"
            name="requested_date"
            class="form-control"
            required />
        </div>
    </fieldset>
    <fieldset>
      <div class="row m-3 p-3 border border-dark rounded shadow">
        <legend class="text-center">Sender Information</legend>
        <div class="col">

          <div>
            <label for="sender_name" class="form-label">Name</label>
            <input type="text" id="sender_name" name="sender_name" class="form-control mb-2" required />
          </div>

          <div>
            <label for="sender_business" class="form-label">Business</label>
            <input type="text" id="sender_business" name="sender_business" class="form-control mb-2" />
          </div>
          <div>
            <label for="sender_phone" class="form-label">Phone Number</label>
            <input type="tel" id="sender_phone" name="sender_phone" class="form-control mb-2" required />
          </div>

          <div>
            <label for="sender_email" class="form-label">Email</label>
            <input
              type="email"
              id="sender_email"
              name="sender_email"
              class="form-control mb-2"
              required />
          </div>
        </div>

        <div class="col">

          <div>
            <label for="sender_address" class="form-label">Address</label>
            <input
              type="text"
              id="sender_address"
              name="sender_address"
              class="form-control mb-2"
              required />
          </div>

          <div>
            <label for="sender_city" class="form-label">City</label>
            <input type="text" id="sender_city" name="sender_city"
              class="form-control mb-2" required />
          </div>

          <div>
            <label for="sender_state" class="form-label">State</label>
            <input
              type="text"
              id="sender_state"
              name="sender_state"
              maxlength="2"
              class="form-control mb-2"
              required />
          </div>

          <div>
            <label for="sender_zip" class="form-label">Zipcode</label>
            <input type="text" id="sender_zip" name="sender_zip" class="form-control mb-2" required />
          </div>
        </div>

      </div>
    </fieldset>
    <fieldset>
      <div class="row m-3 p-3 border border-dark rounded shadow">
        <legend class="text-center">Recipient Information</legend>
        <div class="col">
          <div>
            <label for="recipient_name" class="form-label">Name</label>
            <input
              type="text"
              id="recipient_name"
              name="recipient_name"
              class="form-control mb-2"
              required />
          </div>

          <div>
            <label for="recipient_business" class="form-label">Business</label>
            <input
              type="text"
              id="recipient_business"
              name="recipient_business" class="form-control mb-2" />
          </div>
          <div>
            <label for="recipient_phone" class="form-label">Phone Number</label>
            <input
              type="tel"
              id="recipient_phone"
              name="recipient_phone" class="form-control mb-2"
              required />
          </div>

          <div>
            <label for="recipient_email" class="form-label">Email</label>
            <input
              type="email"
              id="recipient_email"
              name="recipient_email" class="form-control mb-2"
              required />
          </div>
        </div>
        <div class="col">
          <div>
            <label for="recipient_address" class="form-label">Address</label>
            <input
              type="text"
              id="recipient_address"
              name="recipient_address" class="form-control mb-2"
              required />
          </div>

          <div>
            <label for="recipient_city" class="form-label">City</label>
            <input
              type="text"
              id="recipient_city"
              name="recipient_city" class="form-control mb-2"
              required />
          </div>

          <div>
            <label for="recipient_state" class="form-label">State</label>
            <input
              type="text"
              id="recipient_state"
              name="recipient_state"
              maxlength="2"
              class="form-control mb-2"
              required />
          </div>

          <div>
            <label for="recipient_zip" class="form-label">Zipcode</label>
            <input
              type="text"
              id="recipient_zip"
              name="recipient_zip"
              class="form-control mb-2"
              required />
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset>
      <div class="row gap-2 m-3 p-3 border border-dark rounded shadow">

        <legend class="text-center">Shipping Method</legend>

        <div class="col">
          <div class="mb-2">
            <label for="carrier" class="form-label">Carrier</label>
            <select id="carrier" name="carrier" class="form-select" required>
              <option selected>Select Carrier</option>
              <option value="fedex">FedEx</option>
              <option value="ups">UPS</option>
              <option value="usps">USPS</option>
              <option value="dhl">DHL</option>
              <option value="other">Other</option>
            </select>
          </div>




          <div>
            <label for="declared_value" class="form-label">Declared Value (if insured)</label>
            <input
              type="number"
              id="declared_value"
              name="declared_value"
              min="0"
              step="0.01"
              placeholder="USD"
              class="form-control mb-2" />
          </div>
          <label class="form-check-label">Insurance?</label>
          <div class="d-flex flex-row gap-2">

            <div class="form-check">
              <label class="form-check-label" for="insuranceYes">
                Yes
              </label>
              <input class="form-check-input" type="radio" value="yes" name="insurance" id="insuranceYes" />
            </div>

            <div class="form-check">
              <label class="form-check-label" for="insuranceNo">
                No
              </label>
              <input class="form-check-input" type="radio" value="no" name="insurance" id="insuranceNo" checked />
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3">

            <label class="form-check-label">Signature Required?</label>
            <div class="form-check">
              <label class="form-check-label" for="signatureYes">
                Yes
              </label>
              <input class="form-check-input" type="radio" value="yes" name="signature" id="signatureYes" />
            </div>

            <div class="form-check">
              <label class="form-check-label" for="signatureNo">
                No
              </label>
              <input class="form-check-input" type="radio" value="no" name="signature" id="signatureNo" checked />
            </div>
          </div>
          <label>Shipping Speed</label>
          <div class="form-check">
            <label class="form-check-label" for="speedEconomy">
              Economy (3+ days)
            </label>
            <input class="form-check-input" type="radio" value="economy" name="speed" id="speedEconomy" required />
          </div>

          <div class="form-check">
            <label class="form-check-label" for="speedPriority">
              Priority (2–3 days)
            </label>
            <input class="form-check-input" type="radio" value="priority" name="speed" id="speedPriority" />
          </div>

          <div class="form-check">
            <label class="form-check-label" for="speedOvernight">
              Overnight (1 day)
            </label>
            <input class="form-check-input" type="radio" value="overnight" name="speed" id="speedOvernight" />
          </div>


        </div>


      </div>
      <fieldset>
        <div class="row m-3 p-3 border border-dark rounded shadow">
          <legend class="text-center mb-3">Special Instructions</legend>

          <textarea
            id="special_instructions"
            name="special_instructions"
            rows="5"
            class="form-control mb-3"
            placeholder="Enter any additional delivery or packaging notes..."></textarea>

        </div>

      </fieldset>
      <fieldset>
        <div class="row m-3 p-3 border border-dark rounded shadow">
          <legend class="text-center mb-3">Status</legend>
          <div class="col">

            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select mb-3" required>
              <option selected value="Pending">Pending</option>
              <option value="Shipped">Shipped</option>
              <option value="In Transit">In Transit</option>
              <option value="Delivered">Delivered</option>
              <option value="Cancelled">Cancelled</option>
            </select>
          </div>

          <div class="col">
            <label for="tracking" class="form-label">Tracking Number</label>
            <input type="text" name="tracking" id="tracking" class="form-control">
          </div>
          <div class="col">
            <label for="delivery_date" class="form-label">Expected Delivery Date</label>
            <input type="date" name="delivery_date" id="delivery_date" class="form-control">
          </div>



        </div>
      </fieldset>


      <div class="m-5 text-center">
        <button type="submit" class="btn btn-primary">Submit Shipping Form</button>
      </div>
  </form>
</div>
</div>
</div>
</form>
</div>

<script src="../js/form.js"></script>
<?php include '../includes/footer.php'; ?>