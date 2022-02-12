import Router from 'System/Router';
import ErrorHandler from "App/Handler/ErrorHandler";
import IndexHandler from "App/Handler/IndexHandler";
import IndexController from "App/Controller/IndexController";
import LoginHandler from "App/Handler/LoginHandler";
import EventHandler from "App/Handler/EventHandler";

Router
    .notFound(() => {ErrorHandler.handleNotFound()})
    .on('/', () => {IndexController.handle()})
    .on('/login', () => {LoginHandler.handle()})
    .on('/event', () => {EventHandler.handleAbout()})
    .on('/event/list', () => {EventHandler.handleList()})
    .resolve();
