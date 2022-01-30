import BlogCard from "../components/BlogCard";

const BlogPosts = ()=> {
    return (
        <section className="space--sm">
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <div className="masonry">
                            <div className="masonry-filter-container d-flex align-items-center">
                                <span>Category:</span>
                                <div className="masonry-filter-holder">
                                    <div className="masonry__filters" data-filter-all-text="All Categories"></div>
                                </div>
                            </div>
                            <hr />
                                <BlogCard />
                                <div className="pagination">
                                    <a className="pagination__prev" href="#" title="Previous Page">&laquo;</a>
                                    <ol>
                                        <li>
                                            <a href="#">1</a>
                                        </li>
                                        <li>
                                            <a href="#">2</a>
                                        </li>
                                        <li className="pagination__current">3</li>
                                        <li>
                                            <a href="#">4</a>
                                        </li>
                                    </ol>
                                    <a className="pagination__next" href="#" title="Next Page">&raquo;</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default BlogPosts;
