const routes = [];

import Auth from "./partials/Auth";
Array.prototype.push.apply(routes, Auth);

import User from "./partials/User";
Array.prototype.push.apply(routes, User);

import Home from "./partials/Home";
Array.prototype.push.apply(routes, Home);

import Download from "./partials/Download";
Array.prototype.push.apply(routes, Download);

import Formations from "./partials/Formations";
Array.prototype.push.apply(routes, Formations);

import Modules from "./partials/Modules";
Array.prototype.push.apply(routes, Modules);

import Cursus from "./partials/Cursus";
Array.prototype.push.apply(routes, Cursus);

import Bundles from "./partials/Bundles";
Array.prototype.push.apply(routes, Bundles);

import Tutorials from "./partials/Tutorials";
Array.prototype.push.apply(routes, Tutorials);

import Premium from "./partials/Premium";
Array.prototype.push.apply(routes, Premium);

import Products from "./partials/Products";
Array.prototype.push.apply(routes, Products);

import Cart from "./partials/Cart";
Array.prototype.push.apply(routes, Cart);

import Portfolios from "./partials/Portfolios";
Array.prototype.push.apply(routes, Portfolios);

import Tipstricks from "./partials/Tipstricks";
Array.prototype.push.apply(routes, Tipstricks);

import Blog from "./partials/Blog";
Array.prototype.push.apply(routes, Blog);

import Category from "./partials/Category";
Array.prototype.push.apply(routes, Category);

import Tag from "./partials/Tag";
Array.prototype.push.apply(routes, Tag);

import Team from "./partials/Team";
Array.prototype.push.apply(routes, Team);

import Staff from "./partials/Staff";
Array.prototype.push.apply(routes, Staff);

import Services from "./partials/Services";
Array.prototype.push.apply(routes, Services);

import Forum from "./partials/Forum";
Array.prototype.push.apply(routes, Forum);

import Support from "./partials/Support";
Array.prototype.push.apply(routes, Support);

import Features from "./partials/Features";
Array.prototype.push.apply(routes, Features);

import Quotations from "./partials/Quotations";
Array.prototype.push.apply(routes, Quotations);

import Order from "./partials/Order";
Array.prototype.push.apply(routes, Order);

import Faqs from "./partials/Faqs";
Array.prototype.push.apply(routes, Faqs);

import Contact from "./partials/Contact";
Array.prototype.push.apply(routes, Contact);

import Certificates from "./partials/Certificates";
Array.prototype.push.apply(routes, Certificates);

//// ERRORS
import Errors from "./partials/Errors";
Array.prototype.push.apply(routes, Errors);

export default routes;
