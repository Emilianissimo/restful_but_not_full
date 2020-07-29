<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## My docs

Whatever, made your task, which was given like a test exam. Thought I'll beat it by one week or one and half, but spended only half a day. Hope everything right.

## Archiceture

Three models:

- Product
- Category
- Property

Last two has ManyToMany Relationship to Product. Why I made Property even it wasn't in the task? It's solution of making price range. Didn't wanted to make goddamned second float column in the table like:
| min_price | max_price |
Because it's incorrect way to make normal archiceture and I like to module everything. So I made Property, which hasn't price, it exists only in PIVOT table, when ypu connect Product and Property. It seems right. Whatever, after all i just finding the most biggest price and appending into JSON like "maxPrice". Lmao. 

## API, routes, and Controllers

They're exist.

#### Routes 

There is one Resource and two ApiResource routes. Differences are not too much.

#### Controllers

I put controllers (CRUD) inside Admin folder, 'cause I have a habit to make projects by my own and I understand - this functionality will stay only for tight circle of users. Ofc I could make an opened version of "GET" controller, but it wasn't into the task and I got lazy.