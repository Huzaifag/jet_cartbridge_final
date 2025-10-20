<style>
  :root {
      --background-dark: #0a0e17;
      --background-darker: #050811;
      --text-light: #ffffff;
      --primary-color: #4361ee;
      --primary-gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
      --secondary-color: #4cc9f0;
      --accent-color: #f72585;
      --card-bg: rgba(255, 255, 255, 0.05);
      --card-border: rgba(255, 255, 255, 0.08);
      --primary: #3a77ff;
      --secondary: #ff6b01;
      --light-bg: #f8f9fa;
      --dark-text: #2d333a;
  }

  .hero-section {
      background: var(--background-dark);
      padding: 140px 0 100px;
      color: var(--text-light);
      position: relative;
      overflow: hidden;
      min-height: 100vh;
      display: flex;
      align-items: center;
  }

  /* Animated gradient background */
  .hero-section::before {
      content: "";
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle at center, rgba(58, 12, 163, 0.25) 0%, rgba(11, 11, 25, 0) 70%);
      animation: pulse 15s infinite linear;
      z-index: 1;
  }

  .hero-section::after {
      content: "";
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background: linear-gradient(135deg,
              rgba(67, 97, 238, 0.15) 0%,
              rgba(58, 12, 163, 0.15) 50%,
              rgba(247, 37, 133, 0.1) 100%);
      z-index: 2;
  }

  .hero-section>.container {
      position: relative;
      z-index: 3;
  }

  /* Text and Headings */
  .hero-content {
      animation: fadeInUp 1s ease-out forwards;
      opacity: 0;
  }

  .hero-content h1 {
      font-size: 3.75rem;
      font-weight: 700;
      line-height: 1.15;
      margin-bottom: 1.5rem;
      background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.9) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
  }

  .hero-content p {
      font-size: 1.25rem;
      font-weight: 300;
      line-height: 1.6;
      margin-bottom: 2.5rem;
      color: rgba(255, 255, 255, 0.8);
      max-width: 90%;
  }

  /* Search Bar Styling (Enhanced Glass Morphism) */
  .search-container {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(16px) saturate(180%);
      -webkit-backdrop-filter: blur(16px) saturate(180%);
      border-radius: 16px;
      padding: 24px;
      border: 1px solid var(--card-border);
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2),
          inset 0 1px 0 rgba(255, 255, 255, 0.05);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      margin-bottom: 2rem;
  }

  .search-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25),
          inset 0 1px 0 rgba(255, 255, 255, 0.05);
  }

  .input-group {
      background: rgba(0, 0, 0, 0.2);
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.05);
  }

  .hero-search-input {
      background: transparent;
      border: none;
      color: var(--text-light);
      padding: 18px 24px;
      font-size: 1.05rem;
      flex-grow: 1;
  }

  .hero-search-input::placeholder {
      color: rgba(255, 255, 255, 0.5);
  }

  .hero-search-input:focus {
      box-shadow: none;
      outline: none;
      background: rgba(0, 0, 0, 0.1);
  }

  .search-btn {
      background: var(--primary-gradient);
      border: none;
      color: white;
      font-weight: 600;
      padding: 18px 30px;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
  }

  .search-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: all 0.6s ease;
  }

  .search-btn:hover {
      background: linear-gradient(135deg, #4a6cf7 0%, #3f15b3 100%);
  }

  .search-btn:hover::before {
      left: 100%;
  }

  /* Popular Searches */
  .popular-searches {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 0.75rem;
  }

  .popular-searches span {
      color: rgba(255, 255, 255, 0.7);
      font-size: 0.9rem;
  }

  .popular-searches a {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      color: rgba(255, 255, 255, 0.9);
      border-radius: 50px;
      padding: 8px 18px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      text-decoration: none;
  }

  .popular-searches a:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      color: #fff;
  }

  /* Hero Image */
  .hero-image-wrapper {
      position: relative;
      padding: 0;
      border-radius: 20px;
      overflow: hidden;
      animation: fadeInRight 1s ease-out 0.2s forwards;
      opacity: 0;
      transform: translateX(30px);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.05);
  }

  .hero-image {
      border-radius: 20px;
      width: 100%;
      height: auto;
      display: block;
  }

  .hero-image-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(67, 97, 238, 0.1) 0%, rgba(58, 12, 163, 0.1) 100%);
      border-radius: 20px;
  }

  /* Stats Section */
  .hero-stats {
      display: flex;
      gap: 2rem;
      margin-top: 3rem;
      animation: fadeInUp 1s ease-out 0.4s forwards;
      opacity: 0;
  }

  .stat-item {
      display: flex;
      flex-direction: column;
  }

  .stat-value {
      font-size: 2rem;
      font-weight: 700;
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      line-height: 1;
      margin-bottom: 0.5rem;
  }

  .stat-label {
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.7);
  }

  /* Animations */
  @keyframes fadeInUp {
      from {
          opacity: 0;
          transform: translateY(30px);
      }

      to {
          opacity: 1;
          transform: translateY(0);
      }
  }

  @keyframes fadeInRight {
      from {
          opacity: 0;
          transform: translateX(30px);
      }

      to {
          opacity: 1;
          transform: translateX(0);
      }
  }

  @keyframes pulse {
      0% {
          transform: scale(1) rotate(0deg);
          opacity: 0.5;
      }

      50% {
          transform: scale(1.1) rotate(180deg);
          opacity: 0.8;
      }

      100% {
          transform: scale(1) rotate(360deg);
          opacity: 0.5;
      }
  }

  /* Responsive Design */
  @media (max-width: 992px) {
      .hero-content h1 {
          font-size: 3rem;
      }

      .hero-content p {
          max-width: 100%;
      }

      .hero-stats {
          justify-content: center;
      }
  }

  @media (max-width: 768px) {
      .hero-section {
          padding: 120px 0 80px;
          text-align: center;
      }

      .hero-content h1 {
          font-size: 2.5rem;
      }

      .hero-content p {
          font-size: 1.1rem;
      }

      .popular-searches {
          justify-content: center;
      }

      .hero-stats {
          flex-wrap: wrap;
          gap: 1.5rem;
      }

      .stat-item {
          flex: 1;
          min-width: 45%;
      }
  }

          
  .category-card {
      transition: transform 0.3s;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
  }
  
  .category-card:hover {
      transform: translateY(-5px);
  }
  
  .product-card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      height: 100%;
  }
  
  .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  }
  
  .product-img {
      height: 200px;
      object-fit: cover;
  }
  
  .product-price {
      color: var(--secondary);
      font-weight: 700;
      font-size: 1.2rem;
  }
  
  .rating {
      color: #ffc107;
  }
  
  .btn-primary {
      background-color: var(--primary);
      border-color: var(--primary);
  }
  
  .btn-warning {
      background-color: var(--secondary);
      border-color: var(--secondary);
      color: white;
  }
  
  .filter-section {
      background-color: white;
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
  }
  
  .filter-title {
      border-bottom: 2px solid var(--primary);
      padding-bottom: 0.5rem;
      margin-bottom: 1.5rem;
      font-weight: 600;
  }
  
  .user-type-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 1;
  }
  
  .login-prompt {
      background: rgba(255, 255, 255, 0.95);
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s;
      border-radius: 12px;
  }
  
  .product-card:hover .login-prompt {
      opacity: 1;
      visibility: visible;
  }
</style>