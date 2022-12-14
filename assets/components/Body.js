import React from 'react';
import ListArticles from './ListArticles';
import Header from './Header';
import ShoppingCart from './ShoppingCart';
import Footer from './Footer';
import MenuArticles from './MenuArticles';

class Body extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <Header state={this.props.state} />
                <MenuArticles
                    handleAddAllArticles={this.props.handleAddAllArticles}
                    handleAddAllConsoles={this.props.handleAddAllConsoles}
                    handleAddAllGames={this.props.handleAddAllGames}
                />
                <div className='mx-0 mx-sm-3 my-2 text-success'>{this.props.state.msg}</div>
                <div className='mx-0 mx-sm-3 my-2 text-danger'>{this.props.state.error}</div>
                {this.props.state.displayListArticles &&
                    <div>
                        <ListArticles
                            isLogged={this.props.state.isLogged}
                            articles={this.props.state.articles}
                            handleAddOrderLine={this.props.handleAddOrderLine}
                        />
                        { this.props.state.isLogged &&
                            <div
                                className='btn btn-primary mx-0 mx-sm-3 my-3 col-12 col-sm-2'
                                onClick={this.props.handleDisplayShoppingChart}
                            >Valider le panier
                            </div>
                        }
                    </div>
                }
                {this.props.state.displayShoppingChart &&
                    <div>
                        <ShoppingCart
                            orderLines={this.props.state.orderLines}
                            userId={this.props.state.userId}
                            amount={this.props.state.amount}
                            items={this.props.state.items}
                            handleDeleteOrderLine={this.props.handleDeleteOrderLine}
                            handleChangeQuantity={this.props.handleChangeQuantity}
                        />
                        <div
                            className='btn btn-default mb-4'
                            onClick={this.props.handleDisplayListArticles}
                        >Retour ?? la liste des articles</div>
                    </div>
                }
                <Footer state={this.props.state} />
            </div>
        );
    }
}
export default Body;