import {useEffect, useState} from "react";
import {Link} from "react-router-dom";
import {getUserPosts} from "../services/requests";

const Pagination = ({meta: parentMeta, onPaginationClick})=> {
    const [meta, setMeta] = useState(parentMeta);
    const [pageNavs, setPageNavs] = useState([]);
    useEffect(()=> {
        setMeta(parentMeta)
        showPageNavs(parentMeta)
    },[parentMeta])

    const changePage = (e,page)=>{
        e.preventDefault();
        onPaginationClick(page);
    }

    const showPageNavs = (meta)=>{
        const links = [];
        for(let i=1; i <= meta?.last_page; i++){
            links.push(
                <li className={i === meta?.current_page ? 'pagination__current' : ''} key={i}>
                    {
                        i === meta?.current_page && (<span>{i}</span>)
                    }
                    {
                        i !== meta?.current_page  && (<a href="#" onClick={(e)=>changePage(e,i)}>{i}</a>)
                    }
                </li>
            )
        }
        setPageNavs(links)
    }
    return(
        <div className="pagination">
            <ol>
                {pageNavs}
            </ol>
        </div>
    )
}

export default Pagination;
