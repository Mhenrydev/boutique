import React from 'react';
import Body from './Body';

class Main extends React.Component {
    constructor(props) {
        super(props);
        if (localStorage.length == 0) {
            this.state = {
                isLogged: false,
                articles: {
                    list: [],
                    idArticles: []
                },
                items: 0,
                amount: 0,
                orderLines: {
                    lines: [],
                    idArticles: []
                },
                email: '',
                userId: 0,
                displayListArticles: true,
                displayShoppingChart: false,
                error: '',
                msg: ''
            };
            localStorage.setItem('state',JSON.stringify(this.state));
       }
       else {
           this.state = JSON.parse(localStorage.getItem('state'));
        }


        this.setAllArticles();
        this.handleAddOrderLine = this.handleAddOrderLine.bind(this);
        this.handleDeleteOrderLine = this.handleDeleteOrderLine.bind(this);
        this.handleChangeQuantity = this.handleChangeQuantity.bind(this);
        this.handleAddAllArticles = this.handleAddAllArticles.bind(this);
        this.handleAddAllConsoles = this.handleAddAllConsoles.bind(this);
        this.handleAddAllGames = this.handleAddAllGames.bind(this);
        this.handleDisplayListArticles = this.handleDisplayListArticles.bind(this);
        this.handleDisplayShoppingChart = this.handleDisplayShoppingChart.bind(this);
    }

    buildArticles(articles) {
        let list = [];
        let idArticles = [];

        articles.forEach(article => {
            idArticles.push(article.id);
            list.push(article);
        });

        return {
            list: list,
            idArticles: idArticles
        };
    }

    flushMessages() {
        this.setState({
            error: '',
            msg: ''
        });
    }

    getArticle(idArticle) {
        const index = this.state.articles.idArticles.indexOf(idArticle);
        if (index > -1) {
            return this.state.articles.list[index];
        }
        this.setState({ error: 'Erreur dans la liste d\'article' });
    }

    updateItems() {
        let items = 0;

        this.setState((state, props) => {
            state.orderLines.lines.forEach(line => {
                items += line.quantity;
            });
            return { items: items }
        });
    }

    updateAmount() {
        let amount = 0;

        this.setState((state, props) => {
            state.orderLines.lines.forEach(line => {
                amount += line.totalPrice;
            });
            return { amount: amount };
        });
    }

    setAllArticles() {
        const request = new XMLHttpRequest();
        try {
            request.open('GET', '/articles');
            request.responseType = 'json';
            request.addEventListener('load', (event) => {
                this.setState({
                    articles: this.buildArticles(event.target.response.articles),
                    isLogged: event.target.response.isLogged,
                });
                if (event.target.response.isLogged) {
                    this.setState({
                        userId: event.target.response.userId,
                        email: event.target.response.email,
                        msg: event.target.response.msg
                    });
                }
            });
            request.addEventListener('error', () => {
                this.setState({ error: 'Erreur de connection au serveur.' });
            });
            request.send();
        } catch (e) {
            this.setState({ error: 'Erreur de connection au serveur.' });
        }
    }

    handleAddOrderLine(idArticle) {
        this.flushMessages();
        this.setState((state, props) => {
            const index = state.orderLines.idArticles.indexOf(idArticle);
            if (index > -1) {
                state.orderLines.lines[index].quantity++;
                state.orderLines.lines[index].totalPrice += state.orderLines.lines[index].price;
            }
            else {
                state.orderLines.idArticles.push(idArticle);
                const article = this.getArticle(idArticle);
                const orderLine = {
                    idArticle: idArticle,
                    quantity: 1,
                    price: article.price,
                    totalPrice: article.price,
                    nameArticle: article.nameArticle,
                    image: article.image
                }
                state.orderLines.lines.push(orderLine);
            }
            return state;
        });
        this.updateItems();
        this.updateAmount();
    }

    handleDeleteOrderLine(idArticle) {
        this.flushMessages();
        this.setState((state, props) => {
            const index = state.orderLines.idArticles.indexOf(idArticle);
            if (index > -1) {
                state.orderLines.lines.splice(index, 1);
                state.orderLines.idArticles.splice(index, 1);
                return state;
            }
            this.setState({ error: 'Erreur dans la ligne de commande' });
        });
        this.updateItems();
        this.updateAmount();
    }

    handleChangeQuantity(idArticle, event) {
        this.flushMessages();
        this.setState((state, props) => {
            const index = state.orderLines.idArticles.indexOf(idArticle);
            if (index > -1) {
                const quantity = event.target.value.length == 0 ? 0 : parseInt(event.target.value);
                const price = state.orderLines.lines[index].price;
                if (quantity >= 0) {
                    state.orderLines.lines[index].quantity = quantity;
                    state.orderLines.lines[index].totalPrice = quantity * price;
                    return state;
                }
            } else {
                this.setState({ error: 'Erreur dans la ligne de commande' });
            }
        });
        this.updateItems();
        this.updateAmount();
    }

    handleAddAllArticles() {
        this.flushMessages();
        this.setAllArticles();
    }

    handleAddAllConsoles() {
        this.flushMessages();
        const request = new XMLHttpRequest();
        try {
            request.open('GET', 'articles/console');
            request.responseType = 'json';
            request.addEventListener('load', (event) => {
                this.setState({
                    articles: this.buildArticles(event.target.response.articles),
                    isLogged: event.target.response.isLogged,
                });
                if (event.target.response.isLogged) {
                    this.setState({
                        userId: event.target.response.userId,
                        email: event.target.response.email
                    });
                }
            });
            request.addEventListener('error', () => {
                this.setState({ error: 'Erreur de connection au serveur.' });
            });
            request.send();
        } catch (e) {
            this.setState({ error: 'Erreur de connection au serveur.' });
        }
    }

    handleAddAllGames() {
        this.flushMessages();
        const request = new XMLHttpRequest();
        try {
            request.open('GET', 'articles/jeux');
            request.responseType = 'json';
            request.addEventListener('load', (event) => {
                this.setState({
                    articles: this.buildArticles(event.target.response.articles),
                    isLogged: event.target.response.isLogged,
                });
                if (event.target.response.isLogged) {
                    this.setState({
                        userId: event.target.response.userId,
                        email: event.target.response.email
                    });
                }
            });
            request.addEventListener('error', () => {
                this.setState({ error: 'Erreur de connection au serveur.' });
            });
            request.send();
        } catch (e) {
            this.setState({ error: 'Erreur de connection au serveur.' });
        }
    }

    handleDisplayListArticles() {
        this.setState({
            displayListArticles: true,
            displayShoppingChart: false
        });
    }

    handleDisplayShoppingChart() {
        this.setState({
            displayListArticles: false,
            displayShoppingChart: true
        });
    }

    render() {
        return <Body
            state={this.state}
            handleAddOrderLine={this.handleAddOrderLine}
            handleDeleteOrderLine={this.handleDeleteOrderLine}
            handleChangeQuantity={this.handleChangeQuantity}
            handleAddAllArticles={this.handleAddAllArticles}
            handleAddAllConsoles={this.handleAddAllConsoles}
            handleAddAllGames={this.handleAddAllGames}
            handleDisplayListArticles={this.handleDisplayListArticles}
            handleDisplayShoppingChart={this.handleDisplayShoppingChart}
        />;
    }
}

export default Main;