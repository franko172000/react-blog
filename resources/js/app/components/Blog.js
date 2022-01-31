import BlogCard from "./BlogCard";
import Pagination from "./Pagination";
import {useEffect, useState} from "react";

const Blog = ({posts: postData, onPaginationClick}) => {
    const [posts, setPosts] = useState(postData);
    useEffect(()=>{
        setPosts(postData);
    }, [postData])

    const handPaginationClick = (page)=>{
        onPaginationClick(page)
    }
    return(
        <>
            <div className="masonry__container row">
                {
                    posts && posts.data.map(post=>(
                        <BlogCard post={post} key={post.id} />
                    ))
                }
            </div>
            <Pagination onPaginationClick={handPaginationClick} meta={posts?.meta} />
        </>
    )
}

export default Blog;
