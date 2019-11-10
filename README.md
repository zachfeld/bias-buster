## Inspiration
More often than not, the news we consume on a daily basis is full of misleading facts and figures. This web application's primary goal is to help people assess the reliability of the news they consume. Using a machine learning API, We attribute a value from 0 to 1 that measures the level of bias in both the articles title and content. We then take keywords from the content of the article and use the NYT article search API to suggest similar articles. While we understand there is no perfect source of news, we hope to help people base their arguments and opinions on facts as opposed to noise and misdirection.

## What it does
Bias Buster takes a given url, article title, and the content of said article and packs this data into a POST request to a machine learning blackbox called 'fakebox.' Fakebox checks these fields and returns confidence values from 0 (biased) to 1 (impartial). It also returns keywords from the content of the article. We prettify the results, and display the confidence scores. We then take keywords from the article and plug them into the New York Times article search API. We return any number of similar articles, which we scan with fakebox and compare to the original article to ensure they have a better 'bias score' (meaning less biased). Finally, if there are similar articles that are less biased we will recommend them to the user.


## How we built it
We split off into a 'frontend' and 'backend' team, where the 'frontend' team developed the UI using html, css, and bootstrap. The 'backend' team acquired an API key for the 'fakebox' machine learning api and an api key for searching articles on the New York Times database. Using these two api's, we took the keywords returned from the natural language processing of the articles and searched the NYT for similar articles. We plugged those articles back into 'fakebox' to ensure they didn't fall into the same trap of being biased!

## Challenges we ran into
the javascript asynchronous API calls were tricky. We had to learn about promises in javascript in the span of an hour or so, it's definitely something I want to learn more about! Manipulating the return value of a promise turned out to be quite a challenge.

## Accomplishments that we're proud of
We are really proud that we got everything working the way we had hoped in the timeframe! We had an idea we were passionate about and we executed it!

## What we learned
We learned a ton about working with API's in javascript!

## What's next for Bias Buster
In future versions of Bias Buster, we hope to eliminate the need to submit the url, title, and content of the article. Based on the url, we hope to scrape the article for the relevant information. Additionally, we hope to increase the range and accuracy of articles we recommend to users, preferably adding more news sites.
