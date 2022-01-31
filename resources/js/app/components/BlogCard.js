import {Link} from "react-router-dom";

const BlogCard = ({post})=> {
    return(
        <div className="masonry__item col-lg-4 col-md-6">
            <article className="feature feature-1">
                <div className="feature__body boxed boxed--border">
                    <span>{post.publicationDate}</span>
                    <h5>{post.title}</h5>
                    <p>Category: {post.category}</p>
                    <Link to="/post/detail" state={
                        {
                            postId: post.id
                        }
                    }>
                        Read More
                    </Link>
                </div>
            </article>
        </div>
    )
}

export default BlogCard;
