<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Dream Homes Await</title>

  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #f9f9f9; /* Light background color */
      color: #333; /* Dark text color */
    }

    .landing-container {
      text-align: center;
      padding: 0 20px; /* Add padding for small screens */
      height:1000px;
    }

    h1 {
      font-size: 2.5em;
      margin-bottom: 20px;
      color: #1e4150; /* Deep blue heading color */
    }

    p {
      font-size: 1.4em;
      margin-bottom: 30px;
      color: #555; /* Dark gray text color */
    }

    .get-started-button {
      background-color: #e74c3c; /* Red button color */
      color: #ffffff;
      padding: 15px 25px; /* Adjust padding for smaller screens */
      font-size: 1.3em; /* Adjust font size for smaller screens */
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s;
      margin-bottom: 20px; /* Add margin to separate button from cards on small screens */
    }

    .get-started-button:hover {
      background-color: #c0392b; /* Darker red hover color */
    }

    /* Feature Section */
    .feature-section {
      display: flex;
      flex-direction: column; /* Stack items vertically on small screens */
      align-items: center; /* Center align feature cards */
    }

    .feature-box {
      flex: 1;
      padding: 20px;
      margin: 0 0 20px; /* Add margin between feature boxes */
      background: #fff; /* White background for feature boxes */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      transition: transform 0.3s; /* Add transition effect */
    }

    .feature-box:hover {
      transform: none; /* Remove lift on hover effect on small screens */
    }

    .feature-icon {
      font-size: 2.5em;
      color: #3498db;
      margin-bottom: 10px;
    }

    .feature-box h3 {
      font-size: 1.8em;
      color: #1e4150;
      margin-bottom: 10px;
    }

    .feature-box p {
      font-size: 1.2em;
      color: #555;
    }

    /* Adjustments for small screens */
    @media only screen and (max-width: 600px) {
      .landing-container {
        padding: 0 10px; /* Further reduce padding for small screens */
      }

      h1 {
        font-size: 2em; /* Slightly reduce font size */
      }

      p {
        font-size: 1.2em; /* Slightly reduce font size */
      }

      .feature-section {
        align-items: flex-start; /* Align feature cards to the start */
      }
    }
  </style>
</head>
<body>
  <div class="landing-container">
    <h1>Discover Your Dream Homes with Us</h1>
    <p>Unlock the door to extraordinary living. Find the perfect home that suits your lifestyle.</p>
    
    <button onclick="location.href='https://kabaritacoltd.000webhostapp.com/kabarita/startbootstrap-sb-admin-2-master/login.html';" class="get-started-button">Explore Properties</button>
  </div>

  <!-- Feature Section -->
  <div class="feature-section">
    <div class="feature-box">
      <span class="feature-icon">🏠</span>
      <h3>Explore Unique Properties</h3>
      <p>From charming apartments to luxurious villas, find the home that speaks to you.</p>
    </div>

    <div class="feature-box">
      <span class="feature-icon">🌟</span>
      <h3>Exceptional Living Experience</h3>
      <p>Experience a lifestyle beyond compare with our carefully curated selection of homes.</p>
    </div>

    <div class="feature-box">
      <span class="feature-icon">🌐</span>
      <h3>Local Expertise, Global Reach</h3>
      <p>Our dedicated agents bring a wealth of local knowledge, ensuring you make informed decisions.</p>
    </div>
  </div>
</body>
</html>
