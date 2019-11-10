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
      <a class="navbar-brand" href="index.php">
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
	
    <div class="container" id="resultContainer">
      <div class="justify-content-center text-center">
        <!-- Page Content -->
		<br><br><br>
		<!-- Input confidence score thingy -->
        <h2 class="resultFont">This domain is evaluated as</h2>
		<h3 id="domain-result">

		</h3>
		<br>
		<div class="row" id=resultSet>
			<div class="col-8">
				
					<h1>Bias Score for Article Title:</h1>
					<div id="title-percent-count"></div>
					<div id="title-progress-bar">
						<div id="title-progress"></div>
					</div>
					<h1>Bias Score for Article Content:</h1>
					<div id="content-percent-count"></div>
					<div id="content-progress-bar">
						<div id="content-progress"></div>
					</div>
				
			</div>
			<div class="col-4">
				<!-- do somethin data related here--> 
				<h1>keywords pulled from article</h1>
				<ul>
					<li id="key1"></li>
					<li id="key2"></li>
					<li id="key3"></li>
				</ul>
			</div>
		</div>

        
        <br />
        
        <hr />

        <h1 class="resultFont">NYT Article(s) with similar subjects:</h1>

        <!-- Cards for Suggestions-->
		
		<div class="row justify-content-center" id="deck">
			
		</div>
		

      </div>

      <div id="betterTitleScore"></div>
    </div>
  

	
  



<?php
    
    $articleTitle = $_POST['articleTitle'];
    $articleURL = $_POST['articleURL'];
	$articleContent = $_POST['articleContent'];

	$articleContentFixed = trim(preg_replace('/\s+/', ' ', $articleContent));
	$articleContentFixed = str_replace("\"", "\\\"", $articleContentFixed);
    
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
		//console.log(data);

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
			
			//console.log(data);

			let decorate = true;

			const domainName = domain['domain'];
			const domainTrustLevel = domain['category'];

			document.getElementById("domain-result").innerHTML = "<b>" + domainTrustLevel + "</b>";

			switch(domainTrustLevel){
				case "credible":
					document.getElementById("domain-result").innerHTML = "<b>" + domainTrustLevel + "</b> <br /> <p> information from <b>" + domainName + "</b> is usually reputable</p>";
					break;
				case "political":
					document.getElementById("domain-result").innerHTML = "<b>" + domainTrustLevel + "</b> <br /> <p>information from <b>" + domainName + "</b> can have political party biases</p>";
					break;
				case "trusted":
					document.getElementById("domain-result").innerHTML = "<b>" + domainTrustLevel + "</b> <br /> <p>information from <b>" + domainName + "</b> is usually reputable</p>";
					break;
				case "unsure":
					document.getElementById("domain-result").innerHTML = "<b>" + domainTrustLevel + "</b> <br /> <p>process what you read from <b>" + domainName + "</b> with a grain of salt</p>";
					break;
				case "unknown":
					document.getElementById("domain-result").innerHTML = "<b>" + domainTrustLevel + "</b> <br /> <p>there seems to be some kind of issue</p>";
					break;
				case "satire":
					document.getElementById("domain-result").innerHTML = "<b>" + domainTrustLevel + "</b> <br /> <p>information from <b>" + domainName + "</b> is <strong>not</strong> based on fact</p>";
					document.getElementById("resultSet").innerHTML = "<div class='col-12'><h1>Since this source is not reputable, dissecting the contents of the article could lead to misinformation</h1></div>";
					decorate = false;
					break;
				default:
					document.getElementById("resultSet").innerHTML = "<div class='col-12'><h1>Since this source is not reputable, dissecting the contents of the article could lead to misinformation</h1></div>";
					decorate = false;
					break;
			}

			const titleDecision = title['decision'];
			const titleScore = title['score'];
			const titlePercent = titleScore * 100;

			const contentDecision = content['decision'];
			const contentScore = content['score'];
			const contentPercent = contentScore * 100;

			//only run if we have not greyed out the bars, etc.
			if (decorate){
				document.getElementById("title-percent-count").innerHTML = Math.round(titlePercent * 10) / 10 + "% - " + titleDecision;
				document.getElementById("content-percent-count").innerHTML = Math.round(contentPercent * 10) / 10 + "% - " + contentDecision;
				

				let contentColor = "rgb" + "(" + ((1 - contentScore) * 100 ) + "%, " + (contentScore * 100) + "%, 15%)";
				
				document.getElementById("content-progress").style.background = contentColor;
				document.getElementById("content-progress").style.width = "" + (contentScore * 100) + "%" ;

				let titleColor = "rgb" + "(" + ((1 - titleScore) * 100 ) + "%, " + (titleScore * 100) + "%, 15%)";
				
				document.getElementById("title-progress").style.background = titleColor;
				document.getElementById("title-progress").style.width = "" + (titleScore * 100) + "%" ;
			}
			
			
			if (rerun){
				//get keywords from input article content
				keywords = content['keywords'];
				keywordsArray = []
				timesURL = "https://api.nytimes.com/svc/search/v2/articlesearch.json?q="
				for (let i = 1; i < keywords.length; i++){
					keywordsArray[i] = keywords[i]['keyword'];
					//append top 3 keywords
					if (i < 3){
						timesURL += keywordsArray[i] + " ";
					}
					
				}
				//append api key
				timesURL += "&api-key=";
				
				console.log(timesURL);

				//only decorate if we didnt grey out
				if (decorate){
					document.getElementById("key1").innerHTML = keywordsArray[1];
					document.getElementById("key2").innerHTML = keywordsArray[2];
					document.getElementById("key3").innerHTML = keywordsArray[3];
				}
				

				//get articles from NYT
				async function getArticles(url, titleScore, contentScore){
					const response = await fetch(timesURL);
					const data = await response.json();

					console.log(data);
					//array of all article objects
					articles = data['response']['docs'];
					articleStripped = [];

					//no similar articles, print out sorry message
					if (articles.length === 0 ){
							let deck = document.getElementById('deck');
							let line = "<div class='col'>";
							line += "<div class='card' style='margin: auto;'>";
							
							line += "<div class='card-body'>";
            				line += "<h5 class='card-title'></h5>";
							line += "<p class='card-text'>unfortunately, we didn't find any articles similar to the one you searched</p>";	
							line += "</div></card></div>";
							
							deck.innerHTML += line;
					}
					//get three articles max to test
					for (let i = 0; i < 4; i++){
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

						console.log(secondData);
						const { content, domain, title } = secondData;

						const newTitleDecision = title['decision'];
						const newTitleScore = title['score'];

						//if the other searched articles are better than the current article
						if (newTitleScore > .6){
							
							let deck = document.getElementById('deck');
							let line = "<div class='col'>";
							line += "<div class='card' style='margin: auto;'>";
							line += "<img src='images/NYT.jpeg' class='card-img-top justify-content-center text-center' alt='#' id = 'picture'>";
							line += "<div class='card-body'>";
            				line += "<h5 class='card-title'>" + articleStripped[i]['title'] + "</h5>";
							line += "<p class='card-text'>" + articleStripped[i]['content'] +"</p>";	
							line += "</div>";	
            				line += "<a href='" + articleStripped[i]['url'];
							line += "' class='btn btn-light stretched-link'></a></card></div>";
							
							deck.innerHTML += line;
						}
					}

					
				};

				getArticles(timesURL, titleScore, contentScore);

				
			}

		};

		getData(data, true);
			
		

		
    	
    </script>
	</body>
</html>
