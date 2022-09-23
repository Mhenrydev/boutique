import React from 'react';
import Article from './Article';

class ListArticles extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const articles = this.props.articles.list.map(article => <Article
            key={article.id}
            isLogged={this.props.isLogged}
            article={article}
            handleAddOrderLine={this.props.handleAddOrderLine}
        />);

        return (
            <div className='container-fluid mb-3'>
                <div className='row'>
                    {articles}
                </div>
            </div>
        );
    }
}
export default ListArticles;