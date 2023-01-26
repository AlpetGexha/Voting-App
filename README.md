# Voting App
Introducing my new project "Voting App" - the perfect solution for secure, easy and efficient voting. With our app, you can vote from anywhere, at any time, using your mobile device or computer. Our user-friendly interface makes it easy for you to cast your vote, and our state-of-the-art security measures ensure that your vote is protected and counted accurately. Try it out today and experience the convenience and power of online voting.


![Front Page](https://user-images.githubusercontent.com/50520333/214744944-c5c9ce21-fb2b-4427-9347-c0eb9d85e6b4.png)

<details close>
<summary>Single Page</summary>

![Single Page](https://user-images.githubusercontent.com/50520333/214745011-9d95aea1-ed95-4697-85d1-becccafd8ee1.png)

</details>

![Admin Dashboard Light Mode](https://user-images.githubusercontent.com/50520333/214745100-dd3c1d96-d7b0-47cc-86de-c9cdf5dfdc1c.png)

<details close>
<summary>Dark Mode</summary>

![Admin Dashboard Dark Mode](https://user-images.githubusercontent.com/50520333/214745156-eaf1ae73-afa5-4356-9c80-05d912473aa2.png)

</details>

# Installation
```
git clone https://github.com/AlpetGexha/Voting-App.git
cd Voting-App-master
composer update
npm install
cp .env.example .env
php artisan migrate --seed
```
### Start Project
``` 
php artisan serve
```
```
npm run dev
```

Active Queue  
``` 
php artisan queue:work
```
this project contain `Redis` cache & queue if u dont have redis install [here](https://redis.io/docs/getting-started/installation/)

If u like to Active Schedule (optional)
```
schedule:work
```

# Account (Super Admin)
``` 
Email   : admin@gmail.com
Password: admin
```
