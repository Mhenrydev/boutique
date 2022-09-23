import React from 'react';

class MenuArticles extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className='py-4'>
                <div 
                    className='btn btn-default fw-bold'
                    onClick={this.props.handleAddAllArticles}
                    >Tous les articles</div>
                <div 
                    className='btn btn-default fw-bold'
                    onClick={this.props.handleAddAllConsoles}
                    >Consoles</div>
                <div 
                    className='btn btn-default fw-bold'
                    onClick={this.props.handleAddAllGames}
                    >Jeux</div>
            </div>
        );
    }
}
export default MenuArticles;