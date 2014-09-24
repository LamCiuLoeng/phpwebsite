# -*- coding: utf-8 -*-
'''
###########################################
#  Created on 2011-10-25
#  @author: cl.lam
#  Description:
###########################################
'''
from datetime import datetime as dt
from sqlalchemy import create_engine, Column, ForeignKey
from sqlalchemy.types import Integer, DateTime, Text, Unicode
from sqlalchemy.orm import scoped_session, sessionmaker, relation, backref, synonym
from sqlalchemy.ext.declarative import declarative_base


SQLALCHEMY_DATABASE_URI = "mysql://root:root@127.0.0.1:3306/thinkphp?charset=utf8"

engine = create_engine( SQLALCHEMY_DATABASE_URI, echo = False, pool_size = 20 )
maker = sessionmaker( bind = engine, autoflush = True, autocommit = False )
DBSession = scoped_session( maker )
DeclarativeBase = declarative_base()
metadata = DeclarativeBase.metadata

# DBSession.configure(bind = engine)

#===============================================================================
# model define
#===============================================================================

class SysMixin( object ):
    create_time = Column( DateTime, default = dt.now )
    create_by_id = Column( Integer, default = 1 )
    update_time = Column( DateTime, default = dt.now, onupdate = dt.now )
    update_by_id = Column( Integer, default = 1 )
    active = Column( Integer, default = 0 )  # 0 is active ,1 is inactive



class User( DeclarativeBase, SysMixin ):
    __tablename__ = 'thinkphp_user'

    id = Column( Integer, autoincrement = True, primary_key = True )
    name = Column( Unicode( 100 ), nullable = False )
    password = Column( Unicode( 1000 ), nullable = False )
    email = Column( Unicode( 500 ) )



class Category( DeclarativeBase, SysMixin ):
    __tablename__ = 'thinkphp_category'

    id = Column( Integer, autoincrement = True, primary_key = True )
    en_name = Column( Unicode( 1000 ) )
    cn_name = Column( Unicode( 1000 ) )
    en_desc = Column( Text )
    cn_desc = Column( Text )
    order = Column( Integer )




class Product( DeclarativeBase, SysMixin ):
    __tablename__ = 'thinkphp_product'

    id = Column( Integer, autoincrement = True, primary_key = True )
    en_name = Column( Unicode( 500 ) )
    cn_name = Column( Unicode( 500 ) )
    en_desc = Column( Text )
    cn_desc = Column( Text )
    category_id = Column( Integer, ForeignKey( 'thinkphp_category.id' ) )
    category = relation( Category )
    img = Column( Text )
    thumb = Column( Text )


class FileObject( DeclarativeBase, SysMixin ):
    __tablename__ = 'thinkphp_file_object'

    id = Column( Integer, autoincrement = True, primary_key = True )
    name = Column( Unicode( 1000 ), nullable = False )
    path = Column( Unicode( 500 ) )
    url = Column( Unicode( 500 ) )
    type = Column( Unicode( 100 ) )


class PageObject( DeclarativeBase, SysMixin ):
    __tablename__ = 'thinkphp_page_object'

    id = Column( Integer, autoincrement = True, primary_key = True )
    name = Column( Unicode( 1000 ), nullable = False )
    en_title = Column( Unicode( 1000 ) )
    cn_title = Column( Unicode( 1000 ) )
    en_content = Column( Text )
    cn_content = Column( Text )


class DictObject( DeclarativeBase, SysMixin ):
    __tablename__ = 'thinkphp_dict_object'

    id = Column( Integer, autoincrement = True, primary_key = True )
    name = Column( Unicode( 1000 ), nullable = False )
    value = Column(Text)



def init():
    print "drop all tables"
    metadata.drop_all( engine, checkfirst = True )
    print "create table"
    metadata.create_all( engine )
    print "insert default value"

    # default user
    DBSession.add( User( name = "admin", password = "ec54YMO2+jiX8RBizwjrxk5tZVcZ/0/5Yz1LEdcdfmWIpwXM3Q", email = "lamciuloeng@gmail.com" ) )
    # default category
    cs = [
           Category( cn_name = u"地弹簧",en_name=u"floor hinge" ), 
           Category( cn_name = u"闭门器",en_name="door closer"), 
           Category( cn_name = u"门夹",en_name="patch fitting"),
           Category( cn_name = u"配件",en_name="accessories"), 
           Category( cn_name = u"门锁",en_name="door lock"), 
           Category( cn_name = u"浴室夹",en_name="shower hinge"),
           Category( cn_name = u"玻璃门拉手",en_name="door handle"), 
           Category( cn_name = u"门执手",en_name="door knob"), 
           Category( cn_name = u"玻璃连接件",en_name="glass connector"),
           Category( cn_name = u"浴室固定件",en_name="shower stabilizer"),
           Category( cn_name = u"浴室玻璃防水条",en_name="sealing strip"),
           Category( cn_name = u"浴室连接件",en_name="knighthead"),
           Category( cn_name = u"玻璃吸盘",en_name="lifting equipment"),
           Category( cn_name = u"壁橱锁",en_name="cabinet lock"),
           Category( cn_name = u"其他玻璃门连接件",en_name="other glass door fitting"),
           Category( cn_name = u"玻璃爪",en_name="spider system"),
           Category( cn_name = u"楼梯扶手",en_name="handrail"),
           Category( cn_name = u"玻璃槽件",en_name="profile"),
           Category( cn_name = u"其它",en_name="others"),
           ]
    DBSession.add_all( cs )
    for i, c in enumerate( cs ):
        for j in range( 5 ):
            DBSession.add( Product( en_name = "Product-%s-%s" % ( i, j ), cn_name = u"产品-%s-%s" % ( i, j ), category = c ) )

    DBSession.add( PageObject( name = "INTRODUCE", en_title = 'Introduce', cn_title = u'公司简介' ) )
    DBSession.add( PageObject( name = "ABOUTUS", en_title = 'About US', cn_title = u'公司风采' ) )
    DBSession.add( PageObject( name = "CONTACT", en_title = 'Contact US', cn_title = u'联系我们' ) )

    DBSession.add_all([
                      DictObject(name="HERO_1",value=""),DictObject(name="HERO_2",value=""),DictObject(name="HERO_3",value=""),
                      DictObject(name="HOME_EN_CONTENT",value=""),DictObject(name="HOME_CN_CONTENT",value=""),
                      ])


    DBSession.commit()
    print "Done"


if __name__ == "__main__":
    init()
