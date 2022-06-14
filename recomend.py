#!/usr/bin/env python


# ## Movie Recommendation System




import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.metrics.pairwise import linear_kernel
from sklearn.metrics.pairwise import cosine_similarity
from ast import literal_eval
from sys import argv

file_name, film_name = argv
#print(film_name)





path = "/var/www/html/Movies"
imdb_df = pd.read_csv(path + "/imdb.csv")
tmdb_df = pd.read_csv(path + "/tmdb.csv")




tmdb_df.head()





imdb_df.head()





imdb_df.columns = ['id','tittle','cast','crew']
tmdb_df = tmdb_df.merge(imdb_df, on="id")



tmdb_df.head()





# Demographic Filtering
C = tmdb_df["vote_average"].mean()
m = tmdb_df["vote_count"].quantile(0.9)

#print("C: ", C)
#print("m: ", m)

new_tmdb_df = tmdb_df.copy().loc[tmdb_df["vote_count"] >= m]
#print(new_tmdb_df.shape)



def weighted_rating(x, C=C, m=m):
    v = x["vote_count"]
    R = x["vote_average"]

    return (v/(v + m) * R) + (m/(v + m) * C)





new_tmdb_df["score"] = new_tmdb_df.apply(weighted_rating, axis=1)
new_tmdb_df = new_tmdb_df.sort_values('score', ascending=False)

new_tmdb_df[["title", "vote_count", "vote_average", "score"]].head(10)
#smth = new_tmdb_df[["title"]].to_string()
#f = open("demofile3.txt", "w")
#f.write(smth)
#f.close()





def plot():
    popularity = tmdb_df.sort_values("popularity", ascending=False)
    plt.figure(figsize=(12, 6))
    plt.barh(popularity["title"].head(10), popularity["popularity"].head(10), align="center", color="skyblue")
    plt.gca().invert_yaxis()
    plt.title("Top 10 movies")
    plt.xlabel("Popularity")
    plt.show()
    

plot()





# Content based Filtering
#print(tmdb_df["overview"].head(5))





tfidf = TfidfVectorizer(stop_words="english")
tmdb_df["overview"] = tmdb_df["overview"].fillna("")

tfidf_matrix = tfidf.fit_transform(tmdb_df["overview"])
#print(tfidf_matrix.shape)





# Compute similarity
cosine_sim = linear_kernel(tfidf_matrix, tfidf_matrix)
#print(cosine_sim.shape)

indices = pd.Series(tmdb_df.index, index=tmdb_df["title"]).drop_duplicates()
#print(indices.head())




def get_recommendations(title, cosine_sim=cosine_sim):
    """
    in this function,
        we take the cosine score of given movie
        sort them based on cosine score (movie_id, cosine_score)
        take the next 10 values because the first entry is itself
        get those movie indices
        map those indices to titles
        return title list
    """
    idx = indices[title]
    sim_scores = list(enumerate(cosine_sim[idx]))
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
    sim_scores = sim_scores[1:11]
    # (a, b) where a is id of movie, b is sim_score

    movies_indices = [ind[0] for ind in sim_scores]
    movies = tmdb_df["title"].iloc[movies_indices]
    return movies





print("IMDB"+"::")
#print()
#print("Print movie name")
#input1 = input()
input_co_1 = get_recommendations(film_name).to_string(index=False).split('\n')

bext_1 = [i.strip() for i in input_co_1]

print(*bext_1, sep='::',end='::')

#print("::"+get_recommendations(film_name))
#print()
#print("Recommendations for Avengers")
#print(get_recommendations("The Avengers"))





features = ["cast", "crew", "keywords", "genres"]

for feature in features:
    tmdb_df[feature] = tmdb_df[feature].apply(literal_eval)

#tmdb_df[features].head(10)





def get_director(x):
    for i in x:
        if i["job"] == "Director":
            return i["name"]
    return np.nan





def get_list(x):
    if isinstance(x, list):
        names = [i["name"] for i in x]

        if len(names) > 3:
            names = names[:3]

        return names

    return []





tmdb_df["director"] = tmdb_df["crew"].apply(get_director)

features = ["cast", "keywords", "genres"]
for feature in features:
    tmdb_df[feature] = tmdb_df[feature].apply(get_list)





#tmdb_df[['title', 'cast', 'director', 'keywords', 'genres']].head()




def clean_data(x):
    if isinstance(x, list):
        return [str.lower(i.replace(" ", "")) for i in x]
    else:
        if isinstance(x, str):
            return str.lower(x.replace(" ", ""))
        else:
            return ""





features = ['cast', 'keywords', 'director', 'genres']
for feature in features:
    tmdb_df[feature] = tmdb_df[feature].apply(clean_data)





def create_soup(x):
    return ' '.join(x['keywords']) + ' ' + ' '.join(x['cast']) + ' ' + x['director'] + ' ' + ' '.join(x['genres'])


tmdb_df["soup"] = tmdb_df.apply(create_soup, axis=1)
#print(tmdb_df["soup"].head())





count_vectorizer = CountVectorizer(stop_words="english")
count_matrix = count_vectorizer.fit_transform(tmdb_df["soup"])

#print(count_matrix.shape)

cosine_sim2 = cosine_similarity(count_matrix, count_matrix)
#print(cosine_sim2.shape)

tmdb_df = tmdb_df.reset_index()
indices = pd.Series(tmdb_df.index, index=tmdb_df['title'])





print("TMDB"+"::")
#print("Print movie name")
input_co = get_recommendations(film_name, cosine_sim2).to_string(index=False).split('\n')

bext = [i.strip() for i in input_co]

print(*bext, sep='::',end='\n')
#print("::"+get_recommendations(film_name, cosine_sim2))








