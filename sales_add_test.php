<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Data Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    form {
      max-width: 600px;
      margin: auto;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input, select, textarea {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }

    button {
      padding: 10px 15px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      margin-right: 10px;
    }

    button.add-sale {
      background-color: #2196F3;
    }

    button:hover {
      background-color: #45a049;
    }

    .sale-item {
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 20px;
      background-color: #f9f9f9;
    }
  </style>
</head>
<body>
  <h1>Sales Data Submission</h1>
  <form id="sales-form">
    <div id="sales-container">
      <div class="sale-item">
        <div class="form-group">
          <label for="invoice_number">Invoice Number:</label>
          <input type="text" name="invoice_number[]" required>
        </div>
        <div class="form-group">
          <label for="amount">Amount:</label>
          <input type="number" name="amount[]" required>
        </div>
        <div class="form-group">
          <label for="action">Action:</label>
          <input type="text" name="action[]" required>
        </div>
        <div class="form-group">
          <label for="employee_id">Employee ID:</label>
          <input type="text" name="employee_id[]" required>
        </div>
        <div class="form-group">
          <label for="type">Type:</label>
          <input type="text" name="type[]" required>
        </div>
        <div class="form-group">
          <label for="dll">DLL:</label>
          <input type="text" name="dll[]" required>
        </div>
        <div class="form-group">
          <label for="mac_phone">MAC Phone:</label>
          <input type="text" name="mac_phone[]" required>
        </div>
        <div class="form-group">
          <label for="mac_name">MAC Name:</label>
          <input type="text" name="mac_name[]" required>
        </div>
        <div class="form-group">
          <label for="sales_name">Sales Name:</label>
          <input type="text" name="sales_name[]" required>
        </div>
        <div class="form-group">
          <label for="sales_phone">Sales Phone:</label>
          <input type="text" name="sales_phone[]" required>
        </div>
        <div class="form-group">
          <label for="product_id">Product ID:</label>
          <input type="text" name="product_id[]" required>
        </div>
        <div class="form-group">
          <label for="serial_no">Serial No:</label>
          <input type="text" name="serial_no[]" required>
        </div>
        <div class="form-group">
          <label for="customer_type">Customer Type:</label>
          <input type="text" name="customer_type[]" required>
        </div>
        <div class="form-group">
          <label for="nic">NIC:</label>
          <input type="text" name="nic[]" required>
        </div>
        <div class="form-group">
          <label for="customer_name">Customer Name:</label>
          <input type="text" name="customer_name[]" required>
        </div>
        <div class="form-group">
          <label for="customer_address">Customer Address:</label>
          <input type="text" name="customer_address[]" required>
        </div>
        <div class="form-group">
          <label for="customer_contact">Customer Contact:</label>
          <input type="text" name="customer_contact[]" required>
        </div>
        <div class="form-group">
          <label for="pay_amount">Pay Amount:</label>
          <input type="number" name="pay_amount[]" required>
        </div>
      </div>
    </div>
    <button type="button" class="add-sale">Add Another Sale</button>
    <button type="submit">Submit</button>
  </form>

  <script>
    document.querySelector('.add-sale').addEventListener('click', () => {
      const saleContainer = document.getElementById('sales-container');
      const newSale = saleContainer.children[0].cloneNode(true);
      saleContainer.appendChild(newSale);
    });

    document.getElementById('sales-form').addEventListener('submit', async (e) => {
      e.preventDefault();

      // Gather all input data into a JSON payload
      const formData = new FormData(e.target);
      const salesData = [];
      const keys = [...formData.keys()];
      const numSales = keys.filter(key => key === 'invoice_number[]').length;

      for (let i = 0; i < numSales; i++) {
        const sale = {};
        for (const key of keys) {
          if (key.includes('[]')) {
            const trimmedKey = key.replace('[]', '');
            sale[trimmedKey] = formData.getAll(key)[i];
          }
        }
        salesData.push(sale);
      }

      try {
        const response = await fetch('http://localhost/manju/main/pages/manju/sale_save_api.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(salesData),
        });

        const result = await response.json();
        console.log('Server Response:', result);
        alert('Sales data submitted successfully!');
      } catch (error) {
        console.error('Error submitting sales data:', error);
        alert('Error submitting sales data.');
      }
    });
  </script>
</body>
</html>
