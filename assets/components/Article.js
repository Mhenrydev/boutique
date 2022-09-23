import React from 'react';

class Article extends React.Component {
    constructor(props) {
        super(props);
    }

    displayRating(rating) {
        let stars = [];
        for (let i = 0; i < rating; i++) {
            stars.push(
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                </svg>
            );
        }
        for (let i = 0; i < 5 - rating; i++) {
            stars.push(
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                </svg>
            );
        }
        return stars;
    }

    render() {
        return (
            <div className="card col-12 col-sm-3 p-4">
                <img src={'../images/img_boutique/' + this.props.article.image} class="card-img-top" alt="..." />
                <div className="card-body">
                    <h5 className="card-title">
                        <span className='fst-italic'>{this.props.article.nameArticle}</span>
                        <span className='text-success'> {this.props.article.price}</span>
                        <span className='text-success'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-currency-euro" viewBox="0 0 16 16">
                                <path d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936c0-.11 0-.219.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.617 6.617 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z" />
                            </svg>
                        </span>
                    </h5>
                    <hr />
                    <p class="card-text">Rating: {this.displayRating(this.props.article.rating)}</p>
                    <div className='container-fluid'>
                        <div class="row">
                            <div className='col-sm-9'></div>
                            {this.props.isLogged && <div
                                className='btn btn-success col-sm-3 text-center'
                                onClick={this.props.handleAddOrderLine.bind(null, this.props.article.id)}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>
                            </div>
                            }
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
export default Article;