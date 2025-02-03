# RBControl Rewards Integration for WordPress
![Banner Image](banner.png)

## 🚀 Overview
The **RBControl Rewards Integration** plugin seamlessly connects your WordPress site with the RBControl Systems Pool and Spa database. It allows customers to check their reward status directly from their account and provides admin functionalities for account linking.

## 🔧 Features
- 🔹 **Direct SQL Communication** – Securely connects to the RBControl Systems database.
- 🔹 **WooCommerce Integration** – Links customer rewards to their WordPress/WooCommerce account.
- 🔹 **Self-Registration** – Customers can link their WordPress account to their RBControl Customer ID.
- 🔹 **Admin Control** – Admins can manually link/unlink accounts.
- 🔹 **Secure Data Storage** – Safeguards SQL credentials and interactions.

## 🛠️ Prerequisites
Before installing, ensure your server meets the following requirements:
- ✅ [WooCommerce Plugin](https://wordpress.org/plugins/woocommerce/) (Must be installed and activated)
- ✅ `SQLSRV` PHP extension must be installed on the web server

## 📥 Installation
1. **Download & Upload**  
   - Download the latest release from GitHub.
   - Upload the plugin folder to `/wp-content/plugins/`.

2. **Activate the Plugin**  
   - Navigate to `WordPress Admin > Plugins` and activate **RBControl Rewards Integration**.

3. **Configure Database Settings**  
   - Go to `WordPress Admin > Settings > RBControl Rewards`.
   - Enter your **RBControl SQL Server credentials** securely.

4. **Enable Self-Registration (Optional)**  
   - Allow users to register and link their accounts to their RBControl Customer ID.

## 🔐 Security & Zero-Knowledge Encryption
We prioritize security with **zero-knowledge encryption**, ensuring that sensitive database credentials are encrypted before being stored. This means that even if the server is compromised, the raw credentials remain inaccessible.

- **Modern cryptographic methods** with a **randomized encryption key** and **initialization vector (IV)** are used.
- The **AES-256-CBC** encryption standard ensures strong security.
- Data is **salted** and protected against brute-force attacks.

This approach guarantees that **database credentials and customer information remain secure** while maintaining seamless functionality.

## 🏆 How It Works
1. Users can link their **RBControl Customer ID** with their WordPress account.
2. The plugin fetches the **customer’s reward balance** from the RBControl database.
3. Admins can manage and manually link/unlink accounts.
4. The reward status is displayed on the **WooCommerce My Account** page.

## 📌 Roadmap
We are actively working on improving the plugin with these upcoming features:

1. **Optimized Data Fetching** – Reduce database stress by scheduling data pulls **only for active users**, injecting relevant data into MySQL for faster performance.
2. **Expanded Reward Insights** – View current **reward dollar multipliers**, event-based **discounts**, and other promotional details.
3. **Online Reward Redemption** – Allow customers to **redeem and use their rewards online** directly through WooCommerce.
4. **In-Store Receipts** – View and manage **RBControl in-store receipts** from your online account.

## 🖥️ Installing SQLSRV on Linux
To enable SQLSRV on your Linux web server, follow these steps:

### **Step 1: Install Required Packages**
Ensure your system has the required dependencies installed:
```sh
sudo apt update && sudo apt install -y unixodbc unixodbc-dev
Step 2: Add Microsoft Repositories
Download and install the Microsoft ODBC driver for your distribution:

sh
Copy
Edit
curl https://packages.microsoft.com/keys/microsoft.asc | sudo tee /etc/apt/trusted.gpg.d/microsoft.asc
sudo add-apt-repository "$(wget -qO- https://packages.microsoft.com/config/ubuntu/$(lsb_release -rs)/prod.list)"
sudo apt update
sudo apt install -y msodbcsql17
Step 3: Install PHP Drivers
Install the necessary SQLSRV PHP extension:

sh
Copy
Edit
sudo apt install -y php-pear php-dev php-xml
sudo pecl install sqlsrv pdo_sqlsrv
Step 4: Enable Extensions
After installation, enable the SQLSRV extensions by adding them to your PHP configuration:

sh
Copy
Edit
echo "extension=sqlsrv.so" | sudo tee -a /etc/php/*/cli/php.ini
echo "extension=pdo_sqlsrv.so" | sudo tee -a /etc/php/*/cli/php.ini
Step 5: Restart Web Server
Restart your web server for changes to take effect:

sh
Copy
Edit
sudo systemctl restart apache2
🤝 Contributing
We welcome contributions! To contribute:

Fork the repository.
Create a new branch (feature-branch).
Commit changes & submit a pull request.
📄 License
This project is licensed under the MIT License.

📷 Screenshots
(Add screenshots of the settings page and account linking UI here)

⭐ Support & Feedback
Need help? Have a feature request?
Open an issue on GitHub or contact us at support@example.com.

🚀 Elevate your customer experience with RBControl Rewards Integration!

markdown
Copy
Edit

### **Key Updates:**
✅ Improved **Zero-Knowledge Encryption** section with a clear explanation  
✅ Added **full SQLSRV installation guide** for Linux  
✅ Kept your **exact roadmap improvements**  

Let me know if you need any refinements! 🚀