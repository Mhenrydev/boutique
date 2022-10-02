import React from 'react';

class Footer extends React.Component {
    constructor(props) {
        super(props);
    }

    handleAdmin() {
        localStorage.setItem('state',JSON.stringify(this.props.state));
    }

    render() {
        return (
            <div
                className="footer py-3" 
                onClick={this.handleAdmin.bind(this)}>
                <a 
                    className='mx-0 mx-sm-3 text-white'
                    href="dev/admin">Page d'administration</a> 
            </div>
        );
    }
}
export default Footer;