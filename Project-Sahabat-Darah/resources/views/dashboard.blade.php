<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sahabat Darah</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="home-container">
    <a href="{{ route('dashboard') }}" class="nav-item"></a>
    @include('template.header')

        <section class="hero-section">
        <img src="images/herobg.png" class="hero-background" alt="Hero background" />
        <div class="hero-content-wrapper">
          <div class="hero-content-container">
            
            <!-- Text + Indicator -->
            <div class="hero-text-container">
              <div class="hero-text-content">
                <h2 class="hero-title">Sahabat Darah</h2>
                <p class="hero-description">
                  Meningkatkan keamanan, kenyamanan, dan efisiensi rumah sakit
                  dengan otomatisasi berbasis IoT. Sistem ini memastikan kontrol
                  iklim yang steril dan optimal di ruang operasi dan unit
                  perawatan intensif, pemantauan waktu nyata terhadap
                  keselamatan pasien dan pengunjung, serta manajemen otomatis
                  peralatan medis dan stok obat untuk mencegah kekurangan dan
                  pemborosan.
                </p>
              </div>
              <div class="indicator-container">
                <div class="indicator-dot"></div>
              </div>
            </div>

            <!-- Features -->
            <div class="hero-features">
              <div class="features-row">
                <div class="feature-column-cta cta-container">
                  <div class="cta-button">
                    <span class="cta-text">Jelajahi solusi ini</span>
                    <img
                      src="https://cdn.builder.io/api/v1/image/assets/TEMP/14837bdb8a4d12dfe95bb13264af37ba6d207ab0?placeholderIfAbsent=true&apiKey=21bbbea6fa77433d9a84710062831660"
                      class="cta-icon"
                      alt="Arrow icon"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


      <section class="solutions-section">
  <h2 class="section-title">Sahabat Darah</h2>
  <p class="section-subtitle">
    Explore how our innovative approach delivers efficiency and accuracy
    to transform the way you work.
  </p>

  <div class="solutions-grid">
    <div class="solution-card">
      <a href="#management-dashboard" class="solution-link">
        <img src="images/fitur1.png" class="solution-image" alt="Management Dashboard" />
      </a>
      <h3 class="solution-title">Management Dash</h3>
      <p class="solution-description">
        Lorem Ipsum is simply dummy text of the printing and
      </p>
    </div>

    <div class="solution-card">
      <a href="#pmi-search" class="solution-link">
        <img src="images/fitur2.png" class="solution-image" alt="PMI Search" />
      </a>
      <h3 class="solution-title">Pencararian PMI terdekat</h3>
      <p class="solution-description">
        Lorem Ipsum is simply dummy text of the printing and
      </p>
    </div>

    <div class="solution-card">
      <a href="#tracking" class="solution-link">
        <img src="images/fitur3.png" class="solution-image" alt="Tracking Delivery" />
      </a>
      <h3 class="solution-title">Tracking Pengiriman</h3>
      <p class="solution-description">
        Lorem Ipsum is simply dummy text of the printing and
      </p>
    </div>

    <div class="solution-card">
      <a href="#emergency-contact" class="solution-link">
        <img src="images/fitur4.png" class="solution-image" alt="Emergency Contact" />
      </a>
      <h3 class="solution-title">Emergency Contact Hotline</h3>
      <p class="solution-description">
        Lorem Ipsum is simply dummy text of the printing and
      </p>
    </div>
  </div>
</section>



<section class="testimonial-section">
  <div class="testimonial-container">
    <h4 class="testimonial-title">Testimony</h4>
    <div class="testimonial-card">
      <div class="testimonial-left">
        <h3 class="testimonial-client">Rumah Sakit Asih</h3>
        <p class="testimonial-highlight">
          What <span class="highlight-text">our Sahabat Darah</span>
        </p>
        <div class="testimonial-quote">
          <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of ning essentially unchanged. It
          </p>
        </div>
        <p class="testimonial-author">M. Ali Mu'min - Manager Hubungan Langganan</p>
      </div>
      <div class="testimonial-right">
        <img src="images/testimoni.png"
          alt="Testimonial image" class="testimonial-image" />
      </div>
    </div>
  </div>
</section>


<section class="cta-section">
  <img src="images/contactbg.png" alt="CTA Background" class="cta-background" />

  <div class="cta-content">
    <div class="cta-row">
      <div class="cta-text-column">
        <div class="cta-text-content">
          <h2 class="cta-title">
            Solusi <span class="highlight-yellow">Terbaik</span><br />
            Untuk Anda
          </h2>
          <p class="cta-description">
            Kami hadir dengan berbagai solusi yang dirancang untuk kebutuhan Anda—mudah, cepat, dan efisien. Mulailah perjalanan Anda bersama kami hari ini.
          </p>
        </div>
      </div>
      <div class="cta-buttons-column">
        <div class="cta-buttons-container">
          <a href="#" class="cta-button-primary">Hubungi Kami</a>
          <a href="#" class="cta-button-secondary">Pelajari Lebih Lanjut</a>
        </div>
      </div>
    </div>
  </div>
</section>

      @include('template.footer')
    </div>

    <script>
      (() => {
        const state = {};

        let context = null;
        let nodesToDestroy = [];
        let pendingUpdate = false;

        function destroyAnyNodes() {
          // destroy current view template refs before rendering again
          nodesToDestroy.forEach((el) => el.remove());
          nodesToDestroy = [];
        }

        // Function to update data bindings and loops
        // call update() when you mutate state and need the updates to reflect
        // in the dom
        function update() {
          if (pendingUpdate === true) {
            return;
          }
          pendingUpdate = true;

          document.querySelectorAll("[space='190']").forEach((el) => {
            el.setAttribute("space", 190);
          });

          document.querySelectorAll("[space='36']").forEach((el) => {
            el.setAttribute("space", 36);
          });

          document.querySelectorAll("[space='154']").forEach((el) => {
            el.setAttribute("space", 154);
          });

          document.querySelectorAll("[space='220']").forEach((el) => {
            el.setAttribute("space", 220);
          });

          destroyAnyNodes();

          pendingUpdate = false;
        }

        // Update with initial state on first load
        update();
      })();
    </script>
  </body>
</html>
