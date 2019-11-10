<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Results</title>

    <!-- Bootstrap core CSS -->
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Other Stylesheet -->
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>

  <body id="resultsBody">
    <!-- Navigation -->
    <nav class="navbar bg-dark navbar-dark">
      <a class="navbar-brand" href="index.html">
        <img
          src="images/logo.png"
          width="15%"
          height="15%"
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

    <div class="container" id="resultContainer">
      <div class="justify-content-center text-center">
        <!-- Page Content -->
        <h1>Title Confidence Score:</h1>
        <div id="title-percent-count">test</div>
        <div id="title-progress-bar">
          <div id="title-progress"></div>
        </div>
        <h1>Content Confidence Score:</h1>
        <div id="content-percent-count">test</div>
        <div id="content-progress-bar">
          <div id="content-progress"></div>
        </div>

        <!-- Input confidence score thingy -->
        <h2 class="resultFont">This article is evaluated as</h2>
        <br />

        <!-- Type of article identifier -->

        <h2 class="resultFont">Explanation:</h2>
        <hr />

        <h1 class="resultFont">Other Reliable Sources:</h1>

        <!-- Cards for Suggestions-->
        <div class="card-deck">
          <div class="card">
            <img src="..." class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title">Article Title</h5>
              <p class="card-text">Input article description here</p>
            </div>
            <a href="#" class="btn btn-light stretched-link"></a>
          </div>

          <div class="card">
            <img src="..." class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title">Article Title</h5>
              <p class="card-text">Input article description here</p>
            </div>
            <a href="#" class="btn btn-light stretched-link"></a>
          </div>

          <div class="card">
            <img src="#" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title">Article Title</h5>
              <p class="card-text">Input article description here</p>
            </div>
            <a href="#" class="btn btn-light stretched-link"></a>
          </div>
        </div>
      </div>

      <div id="betterTitleScore"></div>
    </div>
  </body>
	
  



<?php
    
    $articleTitle = $_POST['articleTitle'];
    $articleURL = $_POST['articleURL'];
	$articleContent = $_POST['articleContent'];
	$articleContentFixed = trim(preg_replace('/\s+/', ' ', $articleContent));
    
?>
    <script type="text/javascript">
		const api_url = "http://localhost:8080/fakebox/check";
		
    	const URL = "<?php echo $articleURL ?>";
    	const title = "<?php echo $articleTitle ?>";
    	const content = "<?php echo $articleContentFixed ?>";
		
		const data = {
			"url": URL,
			"title": title,
			"content": content
		};
		console.log(data);
		async function getData(articleData, rerun){
			const buildPost = {
			"headers": {"content-type" : "application/json; charset=UTF-8"},
			"body": JSON.stringify(articleData),
			"method": "POST",
			"mode": "cors"
			};
			const response = await fetch(api_url, buildPost);
			const data = await response.json();
			const { content, domain, title } = data;
			
			console.log(data);
			
			const domainName = domain['domain'];
			const domainTrustLevel = domain['category'];
			const titleDecision = title['decision'];
			const titleScore = title['score'];
			const contentDecision = content['decision'];
			const contentScore = content['score'];
			document.getElementById("progress").style.background = "red";
			document.getElementById("progress").style.width = "" + (contentScore * 100) + "%" ;
			console.log(domainName);
			console.log(domainTrustLevel);
			console.log(titleDecision);
			console.log(titleScore);
			console.log(contentDecision);
			console.log(contentScore);
			//document.getElementById("contentScore").innerHTML = contentScore;
			
			if (rerun){
				//get keywords from input article content
				keywords = content['keywords'];
				keywordsArray = []
				timesURL = "https://api.nytimes.com/svc/search/v2/articlesearch.json?q="
				for (let i = 0; i < keywords.length; i++){
					keywordsArray[i] = keywords[i]['keyword'];
					
					//appent top 3 keywords
					if (i < 4){
						timesURL += keywordsArray[i] + " ";
					}
					
				}
				//append api key
				timesURL += "&api-key=KAdEYfi1vX5YCl9Aiamlu1Q7zj0q9R8N";
				
				console.log(timesURL);
				//get articles from NYT
				async function getArticles(url, titleScore, contentScore){
					const response = await fetch(timesURL);
					const data = await response.json();
					//array of all article objects
					articles = data['response']['docs'];
					articleStripped = []
					//get three articles to test
					for (let i = 0; i < 3; i++){
						articleStripped[i] = {
							"url": articles[i]['web_url'],
							"title": articles[i]['headline']['main'],
							"content": articles[i]['snippet'],
						};
						const secondCall = {
							"headers": {"content-type" : "application/json; charset=UTF-8"},
							"body": JSON.stringify(articleStripped[i]),
							"method": "POST",
							"mode": "cors"
						};
						const response = await fetch(api_url, secondCall);
						const secondData = await response.json();
						
						const { content, domain, title } = secondData;
						console.log("Here");
						console.log(content);
						
						
						const newTitleDecision = title['decision'];
						const newTitleScore = title['score'];
						const newContentDecision = content['decision'];
						const newContentScore = content['score'];
						if (newTitleScore > titleScore){
							document.getElementById("betterTitleScore").innerHTML = "this one is better <br />";
							document.getElementById("betterTitleScore").innerHTML += articleStripped[i]['url'];
						}
					}
					
					//console.log(articleStripped);
					
				};
				getArticles(timesURL, titleScore, contentScore);
				
			}
		};
		getData(data, true);
			
		
		
    	
    </script>
		
</html>