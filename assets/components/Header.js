import React from 'react';

class Header extends React.Component {
    constructor(props) {
        super(props);
    }

    displayText() {
        if (this.props.isLogged) {
            return (
                <div className='text-center'>
                    Bienvenue {this.props.email}, vous pouvez vous
                    <a href='#' className='text-success'> déconnecter</a>.
                </div>
            );
        }
        return (
            <div className='text-center'>
                Pour commander 
                <a href='#' className='text-success'> connectez </a> 
                vous ou bien 
                <a href='#' className='text-success'> créez un compte</a>.
            </div>
        )
    }

    render() {
        return (
            <div className="container-fluid">
                <div className='row header-1 pb-3'>
                    <div className='col-12 col-sm-2 text-center fs-4 fw-bold pt-2'>LineshoP</div>
                    <div className='col-12 col-sm-6 py-3 text-center text-sm-start'>
                        The best online store, for real.
                    </div>
                    <div className='col-3 col-sm-1 py-sm-3 text-center text-success'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                        </svg>
                    </div>
                    <div className='col-3 col-sm-1 container'>
                        <div className='row'>
                            <div className='text-center text-success align-text-top'>
                                ITEMS
                            </div>
                        </div>
                        <div className='row'>
                            <div className='text-center fw-bold fs-5 pt-2'>
                                {this.props.items}
                            </div>
                        </div>
                    </div>
                    <div className='col-6 col-sm-2 container'>
                        <div className='row'>
                            <div className='text-center text-success'>
                                TOTAL
                            </div>
                        </div>
                        <div className='row'>
                            <div className='text-center fw-bold fs-5 pt-2'>
                                {this.props.amount}
                            </div>
                        </div>
                    </div>
                </div>
                <div className='row header-2 py-3'>
                    {this.displayText()}
                </div>
            </div >
        )
    }
}
export default Header;