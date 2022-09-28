import React from 'react';
import OrderLine from './OrderLine';

class ShoppingCart extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        let lineNb = 0;
        const orderLines = this.props.orderLines.lines.map(line => {
            lineNb++;
            return <OrderLine
                key={line.idArticle}
                line={line}
                lineNb={lineNb}
                handleDeleteOrderLine={this.props.handleDeleteOrderLine}
                handleChangeQuantity={this.props.handleChangeQuantity}
            />
        });
        return (
            <div>
                <div className='fs-1 shop text-center text-sm-start'>Shopping Cart</div>
                <form
                    method="post"
                    action="order"
                    className='container-fluid mx-0 px-0 mx-sm-3 my-5'
                >
                    {this.props.amount > 0 &&
                        <div className='row fw-bold py-2 d-none d-sm-flex'>
                            <div className='col-3'></div>
                            <div className='col-2 text-center'>Nom de l'article</div>
                            <div className='col-1 text-center'>Quantité</div>
                            <div className='col-2 text-center'>Prix total</div>
                            <div className='col-1 text-center'>Action</div>
                        </div>
                    }
                    {orderLines}
                    <div className='my-4 mx-0 d-flex justify-content-center justify-content-sm-end'>
                        <div className='mx-0 mx-sm-2 text-center text-sm-end'>Montant total de la commande </div>
                        <input
                            type="text"
                            readOnly
                            name="amount"
                            className='text-center text-sm-start'
                            value={this.props.amount}
                        />
                    </div>
                    <input type="submit" className='btn btn-primary col-12 col-sm-2 mx-0' value="Valider la commande" />
                    <input type="hidden" name="user_id" value={this.props.userId} />
                    <input type="hidden" name="lineNb" value={lineNb} />
                    <input type="hidden" name="items" value={this.props.items} />
                </form>
            </div>            
        );
    }
}
export default ShoppingCart;