 
git add Dockerfile
git commit -m "Add Dockerfile for Render deployment"
git push origin master 

---

## 2. **Step 2: Create New Render Service**

Once the **`Dockerfile`** is visible on your GitHub repository, go back to Render:

1.  **Delete any previously failed services** (`laravel-to-do-app`, etc.) to prevent conflicts.
2.  In the Render dashboard, click **+ New** and choose **Web Service**.
3.  Select your repository: **`Aditichoubey-adi/laravel-to-do-app`**.

Now, fill out the settings using the **Docker** runtime:

| Setting | Value | Rationale |
| :--- | :--- | :--- |
| **Language** (Runtime) | **Docker** | Uses the custom `Dockerfile`. |
| **Root Directory** | **Empty** (Leave Blank) | The `Dockerfile` sets the working directory internally. |
| **Dockerfile Path** | **`.`** | Tells Render the `Dockerfile` is in the repository root. |
| **Build Command** | **Empty** (Leave Blank) | The build logic is now inside the `Dockerfile`. |
| **Start Command** | **Empty** (Leave Blank) | The start logic (`CMD ["php-fpm"]`) is inside the `Dockerfile`. |
| **Environment Group** | **`todo-db`** | Ensure your database connection is active. |

* Click **Create Web Service**.

---

## 3. **Step 3: Run Database Migrations**

The deployment will now start building the Docker image (which takes 5-10 minutes). Once the status shows **Live**:

1.  Go to the **Shell tab** in your Web Service dashboard.
2.  Run this command to create the necessary database tables:

    ```bash
    php artisan migrate --force
    
After running the migration command, your application should be fully functional at its Render URL! Let me know once you've successfully pushed the `Dockerfile` to GitHub.