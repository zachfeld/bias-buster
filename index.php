<!DOCTYPE html>
<html>
  <head>
    <title>Article Validator</title>
    <link
      rel="stylesheet"
      type="text/css"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <!-- Personal stylesheet-->
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="images/logo.jpg" rel="shortcut icon" type="image/png" />
    <link
      href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <nav class="navbar bg-dark navbar-dark">
      <a class="navbar-brand" href="index.html">
        <img
          src="images/newspaper.svg"
          width="7%"
          height="7%"
          class="d-inline-block align-top"
          alt="Logo"
        />
        Bentley Programming Club - Bias Buster
      </a>
    </nav>
    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>

    <div>
      <!-- Article Form -->
      <div id="jumboDiv" class="jumbotron">
        <div class="info-form container" style="width:700px">
          <form action="results.php" method="POST" class="form-inlin justify-content-center">
            <h2 id="formTitle">BiasBuster Article Validator</h2>
            <div class="form-group">
              <label for="articleTitle" class="sr-only">Title</label>
              <input
                id="articleTitle"
                name="articleTitle"
                class="form-control form-control-lg"
                type="text"
                placeholder="Input Your Article Title Here"
              />
            </div>
            <div class="form-group">
              <label for="articleURL" class="sr-only">Title</label>
              <input
                id="articleURL"
                name="articleURL"
                class="form-control form-control-lg"
                type="text"
                placeholder="Input Your Article URL Here"
              />
            </div>
            <div class="form-group">
              <label for="articleContent" class="sr-only">Content</label>
              <textarea
                id="articleContent"
                name="articleContent"
                class="form-control form-control-lg"
                type="text"
                rows="4"
                placeholder="Input Your Article Content Here"
              ></textarea>
            </div>
            <div class="text-center">
              <button
                class="btn btn-primary btn-lg btn-light"
                type="submit"
              >
                Submit
              </button>
              </div>
              </form>
        </div>
      </div>
      <!-- Info Box -->
      <main
        class="w3-content w3-padding-large w3-margin-top w3-display-container container"
      >
        <h3>News is complicated...</h3>
        <p>
          More often than not, the news we consume on a daily basis is full 
          of misleading facts and figures. This web application's primary 
          goal is to help people assess the reliability of the news they consume.
          Using a machine learning API, We attribute a value from 0 to 1 that 
          measures the level of bias in both the articles title and content.
          We then take keywords from the content of the article and use the NYT
          article search API to suggest similar articles. While we understand there
          is no perfect source of news, we hope to help people base their arguments and opinions
          on facts as opposed to noise and misdirection.
        </p>
      </main>
  </body>
</html>
